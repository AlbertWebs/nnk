<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\User;

class AssignUsersToGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create group with id 3
        $group = Group::find(3);
        
        if (!$group) {
            $this->command->warn('Group with ID 3 does not exist. Creating it...');
            $group = Group::create([
                'id' => 3,
                'name' => 'Default Group',
                'description' => 'Default group for all members'
            ]);
        }
        
        // Get all users
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run EmailListSeeder first.');
            return;
        }
        
        $assigned = 0;
        $skipped = 0;
        
        foreach ($users as $user) {
            // Check if user is already in the group
            if (!$group->users()->where('user_id', $user->id)->exists()) {
                $group->users()->attach($user->id);
                $assigned++;
            } else {
                $skipped++;
            }
        }
        
        $this->command->info("Assigned {$assigned} users to group '{$group->name}' (ID: {$group->id}). Skipped {$skipped} users already in group.");
    }
}
