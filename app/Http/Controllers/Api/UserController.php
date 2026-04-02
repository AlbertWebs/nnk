<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::with('groups')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'groups' => 'nullable|array',
                'groups.*' => 'exists:groups,id',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt('password'), // Default password, should be changed
                'role' => 'member', // Default role
            ]);

            // Attach groups if provided
            if (!empty($validated['groups'])) {
                $user->groups()->attach($validated['groups']);
            }

            $user->load('groups');

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
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
                'message' => 'Failed to create user',
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
            $user = User::with('groups')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'groups' => 'nullable|array',
                'groups.*' => 'exists:groups,id',
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Sync groups if provided
            if (isset($validated['groups'])) {
                $user->groups()->sync($validated['groups']);
            }

            $user->load('groups');

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
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
                'message' => 'Failed to update user',
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
            $user = User::findOrFail($id);
            $connection = $user->getConnectionName();
            $table = $user->getTable();
            $keyName = $user->getKeyName();

            $maxAttempts = 3;
            $attempt = 0;
            $lastException = null;
            $is1615 = false;

            while ($attempt < $maxAttempts) {
                try {
                    $user = User::findOrFail($id);
                    $user->delete();
                    break;
                } catch (QueryException $e) {
                    // Workaround for MySQL/MariaDB occasional "Prepared statement needs to be re-prepared" (SQLSTATE HY000 / 1615).
                    $is1615 = str_contains($e->getMessage(), 'SQLSTATE[HY000]') && str_contains($e->getMessage(), '1615');
                    if (!$is1615) {
                        throw $e;
                    }

                    $lastException = $e;
                    DB::purge($connection); // Force a fresh connection + statement prep.
                    $attempt++;
                }
            }

            if ($attempt >= $maxAttempts && $lastException) {
                if ($is1615) {
                    // Force a new PDO connection with emulate prepares for this one operation.
                    // This avoids relying on production config cache / env for the PDO attribute.
                    $tempConnectionName = $connection . '_emulate_prepares_tmp';
                    Log::warning('API user delete fallback (emulate prepares) triggered', [
                        'user_id' => $id,
                        'connection' => $connection,
                        'temp_connection' => $tempConnectionName,
                    ]);
                    $baseConfig = config("database.connections.$connection");

                    $baseConfig['options'] = array_merge(
                        $baseConfig['options'] ?? [],
                        [
                            \PDO::ATTR_EMULATE_PREPARES => true,
                            \PDO::ATTR_PERSISTENT => false,
                        ]
                    );

                    config(["database.connections.$tempConnectionName" => $baseConfig]);
                    DB::purge($tempConnectionName);

                    DB::connection($tempConnectionName)
                        ->table($table)
                        ->where($keyName, $id)
                        ->delete();

                    return response()->json([
                        'success' => true,
                        'message' => 'User deleted successfully'
                    ]);
                }

                throw $lastException;
            }

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
