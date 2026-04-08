<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users and departments
        $this->call(UserSeeder::class);
        $this->call(DepartmentSeeder::class);

        // Create categories
        $categories = [
            ['name' => 'Linens', 'description' => 'Bed sheets, pillowcases, towels, and other textile items'],
            ['name' => 'Cleaning Materials', 'description' => 'Detergents, disinfectants, and cleaning supplies'],
            ['name' => 'Toiletries', 'description' => 'Shampoo, soap, toilet paper, and guest amenities'],
            ['name' => 'Maintenance Tools', 'description' => 'Tools and equipment for hotel maintenance'],
            ['name' => 'Kitchen Supplies', 'description' => 'Utensils, plates, and kitchen equipment'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }

        // Create sample items
        $items = [
            ['name' => 'White Bed Sheets', 'category_id' => 1, 'quantity' => 50, 'minimum_stock' => 10, 'unit' => 'sets', 'unit_price' => 25.00],
            ['name' => 'Bath Towels', 'category_id' => 1, 'quantity' => 30, 'minimum_stock' => 15, 'unit' => 'pcs', 'unit_price' => 12.00],
            ['name' => 'All-Purpose Cleaner', 'category_id' => 2, 'quantity' => 8, 'minimum_stock' => 10, 'unit' => 'bottles', 'unit_price' => 8.50],
            ['name' => 'Toilet Paper', 'category_id' => 3, 'quantity' => 100, 'minimum_stock' => 20, 'unit' => 'rolls', 'unit_price' => 1.50],
            ['name' => 'Screwdriver Set', 'category_id' => 4, 'quantity' => 5, 'minimum_stock' => 2, 'unit' => 'sets', 'unit_price' => 35.00],
        ];

        foreach ($items as $item) {
            \App\Models\Item::create($item);
        }

        // Assign existing items to departments
        $this->call(AssignItemsToDepartmentsSeeder::class);
    }
}
