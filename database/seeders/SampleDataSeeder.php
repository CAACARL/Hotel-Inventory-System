<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Department;
use App\Models\Item;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // 5 parent categories with 2 subcategories each
        $categories = [
            ['name' => 'Linens',            'description' => 'Bed sheets and textile items',       'subs' => ['Bed Sheets', 'Towels']],
            ['name' => 'Cleaning Supplies', 'description' => 'Detergents and cleaning products',   'subs' => ['Disinfectants', 'Detergents']],
            ['name' => 'Toiletries',        'description' => 'Guest bathroom amenities',            'subs' => ['Shampoo & Soap', 'Toilet Supplies']],
            ['name' => 'Tools',             'description' => 'Maintenance and repair tools',        'subs' => ['Hand Tools', 'Power Tools']],
            ['name' => 'Office Supplies',   'description' => 'Stationery and office consumables',  'subs' => ['Stationery', 'Printer Supplies']],
        ];

        foreach ($categories as $cat) {
            $parent = Category::firstOrCreate(
                ['name' => $cat['name'], 'parent_id' => null],
                ['description' => $cat['description'], 'is_active' => true]
            );
            foreach ($cat['subs'] as $sub) {
                Category::firstOrCreate(
                    ['name' => $sub, 'parent_id' => $parent->id],
                    ['description' => "$sub under {$cat['name']}", 'is_active' => true]
                );
            }
        }

        // 5 departments
        $departments = [
            ['name' => 'Housekeeping',   'description' => 'Room cleaning and linen management',     'location' => 'Ground Floor'],
            ['name' => 'Kitchen',        'description' => 'Food preparation and catering',           'location' => 'Level 1'],
            ['name' => 'Maintenance',    'description' => 'Facility upkeep and repairs',             'location' => 'Basement'],
            ['name' => 'Front Desk',     'description' => 'Guest reception and check-in',            'location' => 'Lobby'],
            ['name' => 'Administration', 'description' => 'Management and administrative operations','location' => 'Level 2'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], array_merge($dept, ['is_active' => true]));
        }

        $deptIds = Department::pluck('id', 'name');
        $catIds  = Category::pluck('id', 'name');

        // 20 items
        $items = [
            ['name' => 'King Bed Sheets',          'cat' => 'Bed Sheets',       'dept' => 'Housekeeping',   'qty' => 60,  'min' => 15, 'unit' => 'sets',    'price' => 28.00, 'type' => 'non-consumable'],
            ['name' => 'Queen Bed Sheets',         'cat' => 'Bed Sheets',       'dept' => 'Housekeeping',   'qty' => 80,  'min' => 20, 'unit' => 'sets',    'price' => 24.00, 'type' => 'non-consumable'],
            ['name' => 'Bath Towels',              'cat' => 'Towels',           'dept' => 'Housekeeping',   'qty' => 100, 'min' => 25, 'unit' => 'pcs',     'price' => 12.00, 'type' => 'non-consumable'],
            ['name' => 'Hand Towels',              'cat' => 'Towels',           'dept' => 'Housekeeping',   'qty' => 120, 'min' => 30, 'unit' => 'pcs',     'price' => 7.00,  'type' => 'non-consumable'],
            ['name' => 'Floor Disinfectant (5L)',  'cat' => 'Disinfectants',    'dept' => 'Housekeeping',   'qty' => 20,  'min' => 5,  'unit' => 'bottles', 'price' => 18.00, 'type' => 'consumable'],
            ['name' => 'Bleach (1L)',              'cat' => 'Disinfectants',    'dept' => 'Housekeeping',   'qty' => 30,  'min' => 10, 'unit' => 'bottles', 'price' => 5.00,  'type' => 'consumable'],
            ['name' => 'Laundry Detergent (5kg)',  'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 15,  'min' => 5,  'unit' => 'bags',    'price' => 22.00, 'type' => 'consumable'],
            ['name' => 'Dish Soap (1L)',           'cat' => 'Detergents',       'dept' => 'Kitchen',        'qty' => 24,  'min' => 6,  'unit' => 'bottles', 'price' => 4.50,  'type' => 'consumable'],
            ['name' => 'Shampoo Sachets',          'cat' => 'Shampoo & Soap',   'dept' => 'Front Desk',     'qty' => 500, 'min' => 100,'unit' => 'pcs',     'price' => 0.50,  'type' => 'consumable'],
            ['name' => 'Bath Soap Bars',           'cat' => 'Shampoo & Soap',   'dept' => 'Front Desk',     'qty' => 400, 'min' => 80, 'unit' => 'pcs',     'price' => 0.75,  'type' => 'consumable'],
            ['name' => 'Toilet Paper Rolls',       'cat' => 'Toilet Supplies',  'dept' => 'Front Desk',     'qty' => 300, 'min' => 60, 'unit' => 'rolls',   'price' => 1.50,  'type' => 'consumable'],
            ['name' => 'Tissue Boxes',             'cat' => 'Toilet Supplies',  'dept' => 'Front Desk',     'qty' => 100, 'min' => 20, 'unit' => 'boxes',   'price' => 2.00,  'type' => 'consumable'],
            ['name' => 'Screwdriver Set',          'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 10,  'min' => 2,  'unit' => 'sets',    'price' => 35.00, 'type' => 'non-consumable'],
            ['name' => 'Hammer',                   'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 8,   'min' => 2,  'unit' => 'pcs',     'price' => 15.00, 'type' => 'non-consumable'],
            ['name' => 'Wrench Set',               'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 6,   'min' => 2,  'unit' => 'sets',    'price' => 45.00, 'type' => 'non-consumable'],
            ['name' => 'Electric Drill',           'cat' => 'Power Tools',      'dept' => 'Maintenance',    'qty' => 4,   'min' => 1,  'unit' => 'pcs',     'price' => 120.00,'type' => 'non-consumable'],
            ['name' => 'A4 Bond Paper (Ream)',     'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 50,  'min' => 10, 'unit' => 'reams',   'price' => 5.00,  'type' => 'consumable'],
            ['name' => 'Ballpoint Pens (Box)',     'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 30,  'min' => 5,  'unit' => 'boxes',   'price' => 3.50,  'type' => 'consumable'],
            ['name' => 'Ink Cartridge (Black)',    'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 20,  'min' => 5,  'unit' => 'pcs',     'price' => 15.00, 'type' => 'consumable'],
            ['name' => 'Ink Cartridge (Color)',    'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 15,  'min' => 3,  'unit' => 'pcs',     'price' => 18.00, 'type' => 'consumable'],
        ];

        foreach ($items as $i) {
            $catId  = $catIds[$i['cat']]  ?? null;
            $deptId = $deptIds[$i['dept']] ?? null;
            if (!$catId || !$deptId) continue;

            Item::firstOrCreate(
                ['name' => $i['name']],
                [
                    'category_id'   => $catId,
                    'department_id' => $deptId,
                    'quantity'      => $i['qty'],
                    'minimum_stock' => $i['min'],
                    'unit'          => $i['unit'],
                    'unit_price'    => $i['price'],
                    'item_type'     => $i['type'],
                    'status'        => 'available',
                ]
            );
        }
    }
}
