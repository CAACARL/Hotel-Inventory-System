<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@iconvenue.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('innoadmin123-123'),
                'role' => 'admin',
                'department' => 'Administration',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user ready — admin@iconvenue.com / password');
    }
}
