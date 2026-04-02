<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,officer,member',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,officer,member',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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
                Log::warning('User delete fallback (emulate prepares) triggered', [
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

                return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
            }

            throw $lastException;
        }

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
