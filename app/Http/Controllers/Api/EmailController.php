<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\EmailSend;
use App\Models\EmailRecipient;
use App\Mail\GroupEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EmailController extends Controller
{
    private const MAILERSEND_MAX_REQUESTS_PER_MINUTE = 9;
    private const MAILERSEND_RATE_LIMIT_WAIT_SECONDS = 65;

    /**
     * Send email to all members of a group
     */
    public function sendToGroup(Request $request, string $groupId): JsonResponse
    {
        $startTime = now();
        
        try {
            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'body' => 'required|string',
                'attachments.*' => 'nullable|file|max:10240', // Max 10MB per file
            ]);

            $group = Group::with('users')->findOrFail($groupId);
            $allUsers = $group->users->sortBy('id')->values();
            $targetUsers = $allUsers;

            // Skip users who already received the exact same campaign (group + subject + body).
            $alreadySentEmails = EmailRecipient::query()
                ->where('status', 'sent')
                ->whereHas('emailSend', function ($query) use ($groupId, $validated) {
                    $query->where('group_id', $groupId)
                        ->where('subject', $validated['subject'])
                        ->where('body', $validated['body']);
                })
                ->pluck('recipient_email')
                ->filter()
                ->map(fn ($email) => strtolower(trim($email)))
                ->unique()
                ->values();

            $alreadySentSet = array_flip($alreadySentEmails->all());
            $targetUsers = $targetUsers
                ->reject(function ($user) use ($alreadySentSet) {
                    $emailKey = strtolower(trim((string) $user->email));
                    return isset($alreadySentSet[$emailKey]);
                })
                ->values();

            $skippedCount = $allUsers->count() - $targetUsers->count();
            
            // Handle file attachments
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file && $file->isValid()) {
                        // Store file temporarily
                        $path = $file->store('email-attachments', 'public');
                        $attachments[] = [
                            'path' => $path,
                            'name' => $file->getClientOriginalName(),
                            'mime' => $file->getMimeType(),
                        ];
                    }
                }
            }

            // Log email send attempt start
            Log::info('Email send attempt started', [
                'group_id' => $groupId,
                'group_name' => $group->name,
                'subject' => $validated['subject'],
                'recipient_count' => $targetUsers->count(),
                'skipped_count' => $skippedCount,
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email ?? null,
            ]);

            if ($targetUsers->isEmpty()) {
                Log::info('Email send skipped: all members already received this campaign', [
                    'group_id' => $groupId,
                    'group_name' => $group->name,
                    'subject' => $validated['subject'],
                    'skipped_count' => $skippedCount,
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => "No new recipients. {$skippedCount} member(s) already received this email.",
                    'data' => [
                        'group' => $group->name,
                        'sent' => 0,
                        'failed' => 0,
                        'skipped' => $skippedCount,
                        'total' => $allUsers->count(),
                        'errors' => []
                    ]
                ]);
            }

            // Create email send record
            $emailSend = EmailSend::create([
                'group_id' => $groupId,
                'subject' => $validated['subject'],
                'body' => $validated['body'],
                'sent_by' => auth()->id(),
                'total_recipients' => $targetUsers->count(),
                'status' => 'sending',
            ]);

            $sentCount = 0;
            $failedCount = 0;
            $errors = [];
            $windowStartedAt = microtime(true);
            $requestsInWindow = 0;

            foreach ($targetUsers as $user) {
                $recipient = EmailRecipient::create([
                    'email_send_id' => $emailSend->id,
                    'user_id' => $user->id,
                    'recipient_email' => $user->email,
                    'recipient_name' => $user->name,
                    'status' => 'pending',
                ]);

                $sendSucceeded = false;
                $lastError = null;

                for ($attempt = 1; $attempt <= 2; $attempt++) {
                    try {
                        $this->respectMailerSendRateLimit($windowStartedAt, $requestsInWindow);

                        Log::info('Attempting to send email to user', [
                            'user_id' => $user->id,
                            'user_email' => $user->email,
                            'user_name' => $user->name,
                            'group_id' => $groupId,
                            'subject' => $validated['subject'],
                            'attempt' => $attempt,
                        ]);

                        Mail::to($user->email)->send(
                            new GroupEmail($validated['subject'], $validated['body'], $user->name, $attachments)
                        );

                        $requestsInWindow++;
                        $sendSucceeded = true;
                        break;
                    } catch (\Exception $e) {
                        $lastError = $e->getMessage();

                        if ($this->isMailerSendRateLimitError($lastError) && $attempt < 2) {
                            Log::warning('MailerSend rate limit reached, waiting before retry', [
                                'user_id' => $user->id,
                                'user_email' => $user->email,
                                'wait_seconds' => self::MAILERSEND_RATE_LIMIT_WAIT_SECONDS,
                            ]);
                            sleep(self::MAILERSEND_RATE_LIMIT_WAIT_SECONDS);
                            $windowStartedAt = microtime(true);
                            $requestsInWindow = 0;
                            continue;
                        }

                        break;
                    }
                }

                if ($sendSucceeded) {
                    $sentCount++;

                    $recipient->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);
                } else {
                    $failedCount++;
                    $errors[] = [
                        'user' => $user->email,
                        'user_name' => $user->name,
                        'error' => $lastError ?? 'Failed to send email'
                    ];

                    $recipient->update([
                        'status' => 'failed',
                        'error_message' => $lastError ?? 'Failed to send email',
                    ]);
                }
            }

            // Update email send record with final status
            $emailSend->update([
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'status' => $failedCount === $targetUsers->count() ? 'failed' : 'completed',
                'errors' => $errors,
                'sent_at' => now(),
            ]);
            
            // Clean up temporary attachment files
            foreach ($attachments as $attachment) {
                if (Storage::disk('public')->exists($attachment['path'])) {
                    Storage::disk('public')->delete($attachment['path']);
                }
            }

            $duration = now()->diffInSeconds($startTime);
            
            // Log overall email send completion
            Log::info('Email send attempt completed', [
                'group_id' => $groupId,
                'group_name' => $group->name,
                'subject' => $validated['subject'],
                'total_recipients' => $targetUsers->count(),
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'duration_seconds' => $duration,
                'user_id' => auth()->id(),
            ]);

            $allFailed = $sentCount === 0 && $failedCount > 0;

            if ($allFailed) {
                return response()->json([
                    'success' => false,
                    'message' => "Email was not sent. {$failedCount} member(s) failed.",
                    'error' => $errors[0]['error'] ?? 'Failed to send email',
                    'data' => [
                        'group' => $group->name,
                        'sent' => $sentCount,
                        'failed' => $failedCount,
                        'skipped' => $skippedCount,
                        'total' => $targetUsers->count(),
                        'errors' => $errors
                    ]
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => "Email sent to {$sentCount} member(s)" . ($failedCount > 0 ? ", {$failedCount} failed" : ''),
                'data' => [
                    'group' => $group->name,
                    'sent' => $sentCount,
                    'failed' => $failedCount,
                    'skipped' => $skippedCount,
                    'total' => $targetUsers->count(),
                    'errors' => $errors
                ]
            ]);
        } catch (ValidationException $e) {
            Log::warning('Email send attempt failed: Validation error', [
                'group_id' => $groupId,
                'validation_errors' => $e->errors(),
                'user_id' => auth()->id(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Log general exception
            Log::error('Email send attempt failed: General exception', [
                'group_id' => $groupId,
                'error_message' => $errorMessage,
                'error_trace' => $e->getTraceAsString(),
                'exception_class' => get_class($e),
                'user_id' => auth()->id(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email',
                'error' => $errorMessage
            ], 500);
        }
    }

    private function respectMailerSendRateLimit(float &$windowStartedAt, int &$requestsInWindow): void
    {
        $elapsedSeconds = microtime(true) - $windowStartedAt;

        if ($elapsedSeconds >= 60) {
            $windowStartedAt = microtime(true);
            $requestsInWindow = 0;
            return;
        }

        if ($requestsInWindow >= self::MAILERSEND_MAX_REQUESTS_PER_MINUTE) {
            $waitSeconds = (int) ceil(60 - $elapsedSeconds) + 1;
            sleep(max($waitSeconds, 1));
            $windowStartedAt = microtime(true);
            $requestsInWindow = 0;
        }
    }

    private function isMailerSendRateLimitError(?string $errorMessage): bool
    {
        if (!$errorMessage) {
            return false;
        }

        return str_contains($errorMessage, '#MS42903')
            || str_contains(strtolower($errorMessage), 'rate limit');
    }
}
