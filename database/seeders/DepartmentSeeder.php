<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Housekeeping',
                'description' => 'Responsible for cleaning guest rooms, common areas, and maintaining cleanliness standards',
                'location' => 'All Floors',
                'is_active' => true,
            ],
            [
                'name' => 'Front Desk',
                'description' => 'Guest check-in/check-out, reservations, and customer service',
                'location' => 'Ground Floor Lobby',
                'is_active' => true,
            ],
            [
                'name' => 'Kitchen',
                'description' => 'Food preparation, cooking, and kitchen operations',
                'location' => 'Ground Floor Kitchen',
                'is_active' => true,
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Building maintenance, repairs, and technical support',
                'location' => 'Basement Level',
                'is_active' => true,
            ],
            [
                'name' => 'Event Facilities',
                'description' => 'Conference rooms, banquet halls, and event management',
                'location' => '2nd Floor',
                'is_active' => true,
            ],
            [
                'name' => 'Storage',
                'description' => 'Central storage for inventory and supplies',
                'location' => 'Basement Storage Area',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}