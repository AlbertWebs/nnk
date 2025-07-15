<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@nnkstaffsacco.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Officer user
        User::create([
            'name' => 'Loan Officer',
            'email' => 'officer@nnkstaffsacco.com',
            'password' => Hash::make('password'),
            'role' => 'officer',
        ]);

        // Member user
        User::create([
            'name' => 'Member User',
            'email' => 'member@nnkstaffsacco.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);
    }
}
