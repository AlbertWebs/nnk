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
                'batch_option' => 'nullable|string|in:all,first_third,second_third,third_third',
                'attachments.*' => 'nullable|file|max:10240', // Max 10MB per file
            ]);

            $group = Group::with('users')->findOrFail($groupId);
            $batchOption = $validated['batch_option'] ?? 'all';
            $allUsers = $group->users->sortBy('id')->values();
            $totalUsers = $allUsers->count();
            $baseSize = intdiv($totalUsers, 3);
            $remainder = $totalUsers % 3;
            $firstSize = $baseSize + ($remainder > 0 ? 1 : 0);
            $secondSize = $baseSize + ($remainder > 1 ? 1 : 0);
            $thirdStart = $firstSize + $secondSize;

            if ($batchOption === 'first_third') {
                $targetUsers = $allUsers->slice(0, $firstSize)->values();
                $batchLabel = 'Batch 1';
            } elseif ($batchOption === 'second_third') {
                $targetUsers = $allUsers->slice($firstSize, $secondSize)->values();
                $batchLabel = 'Batch 2';
            } elseif ($batchOption === 'third_third') {
                $targetUsers = $allUsers->slice($thirdStart)->values();
                $batchLabel = 'Batch 3';
            } else {
                $targetUsers = $allUsers;
                $batchLabel = 'All members';
            }
            
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
                'batch_option' => $batchOption,
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email ?? null,
            ]);

            if ($targetUsers->isEmpty()) {
                Log::warning('Email send attempt failed: Group has no members', [
                    'group_id' => $groupId,
                    'group_name' => $group->name,
                    'batch_option' => $batchOption,
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'No members found for the selected batch'
                ], 400);
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
            $recipientIds = [];

            foreach ($targetUsers as $user) {
                $recipient = EmailRecipient::create([
                    'email_send_id' => $emailSend->id,
                    'user_id' => $user->id,
                    'recipient_email' => $user->email,
                    'recipient_name' => $user->name,
                    'status' => 'pending',
                ]);
                $recipientIds[] = $recipient->id;
            }

            try {
                $primaryUser = $targetUsers->first();
                $ccEmails = $targetUsers->slice(1)->pluck('email')->filter()->values()->all();

                Log::info('Attempting single email send with CC recipients', [
                    'primary_email' => $primaryUser?->email,
                    'cc_count' => count($ccEmails),
                    'group_id' => $groupId,
                    'subject' => $validated['subject'],
                ]);

                $mailMessage = Mail::to($primaryUser->email);
                if (!empty($ccEmails)) {
                    $mailMessage->cc($ccEmails);
                }

                $mailMessage->send(
                    new GroupEmail($validated['subject'], $validated['body'], $primaryUser->name ?? '', $attachments)
                );

                $sentCount = $targetUsers->count();

                EmailRecipient::whereIn('id', $recipientIds)->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } catch (\Exception $e) {
                $failedCount = $targetUsers->count();
                $errorMessage = $e->getMessage();

                foreach ($targetUsers as $user) {
                    $errors[] = [
                        'user' => $user->email,
                        'user_name' => $user->name,
                        'error' => $errorMessage
                    ];
                }

                EmailRecipient::whereIn('id', $recipientIds)->update([
                    'status' => 'failed',
                    'error_message' => $errorMessage,
                ]);

                Log::error('Failed single email send with CC recipients', [
                    'primary_email' => $targetUsers->first()?->email,
                    'recipient_count' => $targetUsers->count(),
                    'group_id' => $groupId,
                    'subject' => $validated['subject'],
                    'error_message' => $errorMessage,
                    'error_trace' => $e->getTraceAsString(),
                    'exception_class' => get_class($e),
                ]);
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
                'batch_option' => $batchOption,
                'duration_seconds' => $duration,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "Email sent to {$sentCount} member(s)" . ($failedCount > 0 ? ", {$failedCount} failed" : ''),
                'data' => [
                    'group' => $group->name,
                    'batch_option' => $batchOption,
                    'batch_label' => $batchLabel,
                    'sent' => $sentCount,
                    'failed' => $failedCount,
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
}
