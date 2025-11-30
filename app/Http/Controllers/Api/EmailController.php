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
                'attachments.*' => 'nullable|file|max:10240', // Max 10MB per file
            ]);

            $group = Group::with('users')->findOrFail($groupId);
            
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
                'recipient_count' => $group->users->count(),
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email ?? null,
            ]);

            if ($group->users->isEmpty()) {
                Log::warning('Email send attempt failed: Group has no members', [
                    'group_id' => $groupId,
                    'group_name' => $group->name,
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Group has no members'
                ], 400);
            }

            // Create email send record
            $emailSend = EmailSend::create([
                'group_id' => $groupId,
                'subject' => $validated['subject'],
                'body' => $validated['body'],
                'sent_by' => auth()->id(),
                'total_recipients' => $group->users->count(),
                'status' => 'sending',
            ]);

            $sentCount = 0;
            $failedCount = 0;
            $errors = [];

            foreach ($group->users as $user) {
                // Create recipient record
                $recipient = EmailRecipient::create([
                    'email_send_id' => $emailSend->id,
                    'user_id' => $user->id,
                    'recipient_email' => $user->email,
                    'recipient_name' => $user->name,
                    'status' => 'pending',
                ]);

                try {
                    // Log individual email attempt
                    Log::info('Attempting to send email to user', [
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'user_name' => $user->name,
                        'group_id' => $groupId,
                        'subject' => $validated['subject'],
                    ]);

                    Mail::to($user->email)->send(
                        new GroupEmail($validated['subject'], $validated['body'], $user->name, $attachments)
                    );
                    
                    $sentCount++;
                    
                    // Update recipient record as sent
                    $recipient->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);
                    
                    // Log successful send
                    Log::info('Email sent successfully to user', [
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'group_id' => $groupId,
                        'subject' => $validated['subject'],
                    ]);
                } catch (\Exception $e) {
                    $failedCount++;
                    $errorMessage = $e->getMessage();
                    $errors[] = [
                        'user' => $user->email,
                        'user_name' => $user->name,
                        'error' => $errorMessage
                    ];
                    
                    // Update recipient record as failed
                    $recipient->update([
                        'status' => 'failed',
                        'error_message' => $errorMessage,
                    ]);
                    
                    // Log failed email attempt with full error details
                    Log::error('Failed to send email to user', [
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'user_name' => $user->name,
                        'group_id' => $groupId,
                        'subject' => $validated['subject'],
                        'error_message' => $errorMessage,
                        'error_trace' => $e->getTraceAsString(),
                        'exception_class' => get_class($e),
                    ]);
                }
            }

            // Update email send record with final status
            $emailSend->update([
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'status' => $failedCount === $group->users->count() ? 'failed' : 'completed',
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
                'total_recipients' => $group->users->count(),
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
                'duration_seconds' => $duration,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "Email sent to {$sentCount} member(s)" . ($failedCount > 0 ? ", {$failedCount} failed" : ''),
                'data' => [
                    'group' => $group->name,
                    'sent' => $sentCount,
                    'failed' => $failedCount,
                    'total' => $group->users->count(),
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
