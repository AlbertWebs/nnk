<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Mail\GroupEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class EmailController extends Controller
{
    /**
     * Send email to all members of a group
     */
    public function sendToGroup(Request $request, string $groupId): JsonResponse
    {
        try {
            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'body' => 'required|string',
            ]);

            $group = Group::with('users')->findOrFail($groupId);

            if ($group->users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Group has no members'
                ], 400);
            }

            $sentCount = 0;
            $failedCount = 0;
            $errors = [];

            foreach ($group->users as $user) {
                try {
                    Mail::to($user->email)->send(
                        new GroupEmail($validated['subject'], $validated['body'], $user->name)
                    );
                    $sentCount++;
                } catch (\Exception $e) {
                    $failedCount++;
                    $errors[] = [
                        'user' => $user->email,
                        'error' => $e->getMessage()
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Email sent to {$sentCount} member(s)",
                'data' => [
                    'group' => $group->name,
                    'sent' => $sentCount,
                    'failed' => $failedCount,
                    'errors' => $errors
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
