<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        $user = User::create([
            'name' => 'User One',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Cannot reset password',
            'description' => 'I keep getting an error when trying to reset my password.',
            'status' => 'open',
            'priority' => 'high',
        ]);

        Ticket::create([
            'user_id' => $admin->id,
            'subject' => 'Server disk usage is high',
            'description' => 'Disk usage on the main server passed 90 percent.',
            'status' => 'open',
            'priority' => 'medium',
        ]);
    }
}
