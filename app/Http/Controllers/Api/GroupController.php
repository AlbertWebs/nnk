<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $groups = Group::with('users')->withCount('users')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:groups,name',
                'description' => 'nullable|string',
            ]);

            $group = Group::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Group created successfully',
                'data' => $group
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $group = Group::with('users')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $group
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Group not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $group = Group::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:groups,name,' . $id,
                'description' => 'nullable|string',
            ]);

            $group->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Group updated successfully',
                'data' => $group
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
                'message' => 'Failed to update group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $group = Group::findOrFail($id);
            $group->delete();

            return response()->json([
                'success' => true,
                'message' => 'Group deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add a user to a group
     */
    public function addUser(Request $request, string $groupId, string $userId): JsonResponse
    {
        try {
            $group = Group::findOrFail($groupId);
            $user = \App\Models\User::findOrFail($userId);

            // Check if user is already in the group
            if ($group->users()->where('user_id', $userId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is already in this group'
                ], 400);
            }

            $group->users()->attach($userId);

            return response()->json([
                'success' => true,
                'message' => 'User added to group successfully',
                'data' => [
                    'group' => $group->load('users'),
                    'user' => $user
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add user to group',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a user from a group
     */
    public function removeUser(string $groupId, string $userId): JsonResponse
    {
        try {
            $group = Group::findOrFail($groupId);
            $user = \App\Models\User::findOrFail($userId);

            $group->users()->detach($userId);

            return response()->json([
                'success' => true,
                'message' => 'User removed from group successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove user from group',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
