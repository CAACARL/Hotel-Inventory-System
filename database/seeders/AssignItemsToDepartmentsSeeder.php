<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Department;

class AssignItemsToDepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get departments
        $housekeeping = Department::where('name', 'Housekeeping')->first();
        $kitchen = Department::where('name', 'Kitchen')->first();
        $maintenance = Department::where('name', 'Maintenance')->first();
        $storage = Department::where('name', 'Storage')->first();
        $frontDesk = Department::where('name', 'Front Desk')->first();

        // Assign items to appropriate departments based on their category and name
        $itemAssignments = [
            // Linens go to Housekeeping
            'White Bed Sheets' => $housekeeping->id,
            'Bath Towels' => $housekeeping->id,
            
            // Cleaning materials go to Housekeeping
            'All-Purpose Cleaner' => $housekeeping->id,
            
            // Toiletries can go to Storage (central supply)
            'Toilet Paper' => $storage->id,
            
            // Tools go to Maintenance
            'Screwdriver Set' => $maintenance->id,
        ];

        // Update existing items
        foreach ($itemAssignments as $itemName => $departmentId) {
            Item::where('name', $itemName)->update(['department_id' => $departmentId]);
        }

        // For any remaining items without departments, assign to Storage as default
        Item::whereNull('department_id')->update(['department_id' => $storage->id]);

        echo "Items successfully assigned to departments!\n";
    }
}