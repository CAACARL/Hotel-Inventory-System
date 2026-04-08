<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        if (!User::where('email', 'admin@iconvenue.com')->exists()) {
            User::create([
                'name' => 'System Administrator',
                'email' => 'admin@iconvenue.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department' => 'Administration',
                'is_active' => true,
            ]);
        }

        // Create staff user if it doesn't exist
        if (!User::where('email', 'staff@iconvenue.com')->exists()) {
            User::create([
                'name' => 'Staff Member',
                'email' => 'staff@iconvenue.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'department' => 'Operations',
                'is_active' => true,
            ]);
        }

        // Create additional sample users
        $sampleUsers = [
            [
                'name' => 'John Manager',
                'email' => 'john.manager@iconvenue.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department' => 'Management',
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@iconvenue.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'department' => 'Housekeeping',
                'is_active' => true,
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'mike.wilson@iconvenue.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'department' => 'Maintenance',
                'is_active' => true,
            ],
            [
                'name' => 'Lisa Brown',
                'email' => 'lisa.brown@iconvenue.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'department' => 'Front Desk',
                'is_active' => false,
            ],
        ];

        foreach ($sampleUsers as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }
    }
}