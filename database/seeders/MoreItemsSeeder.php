<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Department;
use App\Models\Item;

class MoreItemsSeeder extends Seeder
{
    public function run(): void
    {
        $deptIds = Department::pluck('id', 'name');
        $catIds  = Category::pluck('id', 'name');

        $items = [
            // Bed Sheets
            ['name' => 'Single Bed Sheets',           'cat' => 'Bed Sheets',       'dept' => 'Housekeeping',   'qty' => 70,  'min' => 15, 'unit' => 'sets',    'price' => 18.00, 'type' => 'non-consumable'],
            ['name' => 'Fitted Sheets (Queen)',        'cat' => 'Bed Sheets',       'dept' => 'Housekeeping',   'qty' => 50,  'min' => 10, 'unit' => 'pcs',     'price' => 20.00, 'type' => 'non-consumable'],
            ['name' => 'Duvet Covers (King)',          'cat' => 'Bed Sheets',       'dept' => 'Housekeeping',   'qty' => 40,  'min' => 10, 'unit' => 'pcs',     'price' => 32.00, 'type' => 'non-consumable'],
            ['name' => 'Pillowcases (Standard)',       'cat' => 'Bed Sheets',       'dept' => 'Housekeeping',   'qty' => 200, 'min' => 40, 'unit' => 'pcs',     'price' => 5.00,  'type' => 'non-consumable'],
            ['name' => 'Mattress Protectors',          'cat' => 'Bed Sheets',       'dept' => 'Housekeeping',   'qty' => 30,  'min' => 8,  'unit' => 'pcs',     'price' => 25.00, 'type' => 'non-consumable'],
            // Towels
            ['name' => 'Pool Towels',                  'cat' => 'Towels',           'dept' => 'Housekeeping',   'qty' => 80,  'min' => 20, 'unit' => 'pcs',     'price' => 15.00, 'type' => 'non-consumable'],
            ['name' => 'Face Towels',                  'cat' => 'Towels',           'dept' => 'Housekeeping',   'qty' => 150, 'min' => 30, 'unit' => 'pcs',     'price' => 4.50,  'type' => 'non-consumable'],
            ['name' => 'Kitchen Towels',               'cat' => 'Towels',           'dept' => 'Kitchen',        'qty' => 60,  'min' => 15, 'unit' => 'pcs',     'price' => 3.50,  'type' => 'non-consumable'],
            ['name' => 'Gym Towels',                   'cat' => 'Towels',           'dept' => 'Housekeeping',   'qty' => 50,  'min' => 10, 'unit' => 'pcs',     'price' => 8.00,  'type' => 'non-consumable'],
            // Disinfectants
            ['name' => 'Bathroom Disinfectant (1L)',   'cat' => 'Disinfectants',    'dept' => 'Housekeeping',   'qty' => 40,  'min' => 10, 'unit' => 'bottles', 'price' => 9.00,  'type' => 'consumable'],
            ['name' => 'Surface Sanitizer (500ml)',    'cat' => 'Disinfectants',    'dept' => 'Housekeeping',   'qty' => 35,  'min' => 8,  'unit' => 'bottles', 'price' => 7.50,  'type' => 'consumable'],
            ['name' => 'Hand Sanitizer (500ml)',       'cat' => 'Disinfectants',    'dept' => 'Front Desk',     'qty' => 50,  'min' => 10, 'unit' => 'bottles', 'price' => 6.00,  'type' => 'consumable'],
            ['name' => 'Toilet Bowl Cleaner (750ml)',  'cat' => 'Disinfectants',    'dept' => 'Housekeeping',   'qty' => 30,  'min' => 8,  'unit' => 'bottles', 'price' => 5.50,  'type' => 'consumable'],
            ['name' => 'Mold Remover Spray (500ml)',   'cat' => 'Disinfectants',    'dept' => 'Maintenance',    'qty' => 20,  'min' => 5,  'unit' => 'bottles', 'price' => 11.00, 'type' => 'consumable'],
            // Detergents
            ['name' => 'Fabric Softener (5L)',         'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 18,  'min' => 5,  'unit' => 'bottles', 'price' => 16.00, 'type' => 'consumable'],
            ['name' => 'Dishwasher Tablets (Box)',     'cat' => 'Detergents',       'dept' => 'Kitchen',        'qty' => 25,  'min' => 6,  'unit' => 'boxes',   'price' => 14.00, 'type' => 'consumable'],
            ['name' => 'Stain Remover (1L)',           'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 22,  'min' => 5,  'unit' => 'bottles', 'price' => 10.00, 'type' => 'consumable'],
            ['name' => 'Glass Cleaner (500ml)',        'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 28,  'min' => 6,  'unit' => 'bottles', 'price' => 6.50,  'type' => 'consumable'],
            // Shampoo & Soap
            ['name' => 'Conditioner Sachets',          'cat' => 'Shampoo & Soap',   'dept' => 'Front Desk',     'qty' => 500, 'min' => 100,'unit' => 'pcs',     'price' => 0.50,  'type' => 'consumable'],
            ['name' => 'Body Lotion Sachets',          'cat' => 'Shampoo & Soap',   'dept' => 'Front Desk',     'qty' => 400, 'min' => 80, 'unit' => 'pcs',     'price' => 0.75,  'type' => 'consumable'],
            ['name' => 'Liquid Hand Soap (500ml)',     'cat' => 'Shampoo & Soap',   'dept' => 'Front Desk',     'qty' => 60,  'min' => 15, 'unit' => 'bottles', 'price' => 4.00,  'type' => 'consumable'],
            ['name' => 'Shower Gel Sachets',           'cat' => 'Shampoo & Soap',   'dept' => 'Front Desk',     'qty' => 350, 'min' => 70, 'unit' => 'pcs',     'price' => 0.60,  'type' => 'consumable'],
            // Toilet Supplies
            ['name' => 'Paper Towel Rolls',            'cat' => 'Toilet Supplies',  'dept' => 'Front Desk',     'qty' => 200, 'min' => 40, 'unit' => 'rolls',   'price' => 1.80,  'type' => 'consumable'],
            ['name' => 'Toilet Seat Covers (Box)',     'cat' => 'Toilet Supplies',  'dept' => 'Front Desk',     'qty' => 80,  'min' => 20, 'unit' => 'boxes',   'price' => 3.00,  'type' => 'consumable'],
            ['name' => 'Air Freshener Spray (300ml)',  'cat' => 'Toilet Supplies',  'dept' => 'Housekeeping',   'qty' => 45,  'min' => 10, 'unit' => 'cans',    'price' => 5.00,  'type' => 'consumable'],
            ['name' => 'Trash Bags (Box of 50)',       'cat' => 'Toilet Supplies',  'dept' => 'Housekeeping',   'qty' => 60,  'min' => 15, 'unit' => 'boxes',   'price' => 4.50,  'type' => 'consumable'],
            // Hand Tools
            ['name' => 'Tape Measure (5m)',            'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 10,  'min' => 2,  'unit' => 'pcs',     'price' => 8.00,  'type' => 'non-consumable'],
            ['name' => 'Pliers Set',                   'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 8,   'min' => 2,  'unit' => 'sets',    'price' => 28.00, 'type' => 'non-consumable'],
            ['name' => 'Utility Knife',                'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 12,  'min' => 3,  'unit' => 'pcs',     'price' => 6.00,  'type' => 'non-consumable'],
            ['name' => 'Level Tool (60cm)',            'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 5,   'min' => 1,  'unit' => 'pcs',     'price' => 18.00, 'type' => 'non-consumable'],
            ['name' => 'Hacksaw',                      'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 4,   'min' => 1,  'unit' => 'pcs',     'price' => 22.00, 'type' => 'non-consumable'],
            ['name' => 'Caulking Gun',                 'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 6,   'min' => 2,  'unit' => 'pcs',     'price' => 12.00, 'type' => 'non-consumable'],
            ['name' => 'Paint Brushes (Set)',          'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 10,  'min' => 3,  'unit' => 'sets',    'price' => 15.00, 'type' => 'non-consumable'],
            // Power Tools
            ['name' => 'Jigsaw',                       'cat' => 'Power Tools',      'dept' => 'Maintenance',    'qty' => 2,   'min' => 1,  'unit' => 'pcs',     'price' => 180.00,'type' => 'non-consumable'],
            ['name' => 'Circular Saw',                 'cat' => 'Power Tools',      'dept' => 'Maintenance',    'qty' => 2,   'min' => 1,  'unit' => 'pcs',     'price' => 220.00,'type' => 'non-consumable'],
            ['name' => 'Rotary Hammer Drill',          'cat' => 'Power Tools',      'dept' => 'Maintenance',    'qty' => 3,   'min' => 1,  'unit' => 'pcs',     'price' => 250.00,'type' => 'non-consumable'],
            ['name' => 'Orbital Sander',               'cat' => 'Power Tools',      'dept' => 'Maintenance',    'qty' => 3,   'min' => 1,  'unit' => 'pcs',     'price' => 90.00, 'type' => 'non-consumable'],
            ['name' => 'Heat Gun',                     'cat' => 'Power Tools',      'dept' => 'Maintenance',    'qty' => 2,   'min' => 1,  'unit' => 'pcs',     'price' => 65.00, 'type' => 'non-consumable'],
            // Stationery
            ['name' => 'Sticky Notes (Pack)',          'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 40,  'min' => 10, 'unit' => 'packs',   'price' => 2.50,  'type' => 'consumable'],
            ['name' => 'Highlighters (Box)',           'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 25,  'min' => 5,  'unit' => 'boxes',   'price' => 4.00,  'type' => 'consumable'],
            ['name' => 'Folders (Box of 10)',          'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 30,  'min' => 8,  'unit' => 'boxes',   'price' => 6.00,  'type' => 'consumable'],
            ['name' => 'Envelopes (Box of 100)',       'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 20,  'min' => 5,  'unit' => 'boxes',   'price' => 5.50,  'type' => 'consumable'],
            ['name' => 'Correction Tape',              'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 35,  'min' => 8,  'unit' => 'pcs',     'price' => 1.50,  'type' => 'consumable'],
            ['name' => 'Scissors',                     'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 15,  'min' => 3,  'unit' => 'pcs',     'price' => 3.00,  'type' => 'non-consumable'],
            ['name' => 'Tape Dispenser',               'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 10,  'min' => 2,  'unit' => 'pcs',     'price' => 4.50,  'type' => 'non-consumable'],
            ['name' => 'Whiteboard Markers (Box)',     'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 20,  'min' => 5,  'unit' => 'boxes',   'price' => 5.00,  'type' => 'consumable'],
            ['name' => 'Rubber Bands (Box)',           'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 25,  'min' => 5,  'unit' => 'boxes',   'price' => 1.00,  'type' => 'consumable'],
            ['name' => 'Paper Clips (Box)',            'cat' => 'Stationery',       'dept' => 'Administration', 'qty' => 30,  'min' => 8,  'unit' => 'boxes',   'price' => 0.80,  'type' => 'consumable'],
            // Printer Supplies
            ['name' => 'Ink Cartridge (Cyan)',         'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 12,  'min' => 3,  'unit' => 'pcs',     'price' => 18.00, 'type' => 'consumable'],
            ['name' => 'Ink Cartridge (Magenta)',      'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 12,  'min' => 3,  'unit' => 'pcs',     'price' => 18.00, 'type' => 'consumable'],
            ['name' => 'Ink Cartridge (Yellow)',       'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 12,  'min' => 3,  'unit' => 'pcs',     'price' => 18.00, 'type' => 'consumable'],
            ['name' => 'Toner Cartridge (Black)',      'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 8,   'min' => 2,  'unit' => 'pcs',     'price' => 55.00, 'type' => 'consumable'],
            ['name' => 'A3 Bond Paper (Ream)',         'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 20,  'min' => 5,  'unit' => 'reams',   'price' => 9.00,  'type' => 'consumable'],
            ['name' => 'Photo Paper (Pack of 50)',     'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 15,  'min' => 3,  'unit' => 'packs',   'price' => 12.00, 'type' => 'consumable'],
            ['name' => 'Printer Cleaning Kit',         'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 5,   'min' => 1,  'unit' => 'kits',    'price' => 20.00, 'type' => 'consumable'],
            // Extra items spread across depts
            ['name' => 'Mop and Bucket Set',           'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 15,  'min' => 4,  'unit' => 'sets',    'price' => 30.00, 'type' => 'non-consumable'],
            ['name' => 'Broom and Dustpan Set',        'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 20,  'min' => 5,  'unit' => 'sets',    'price' => 12.00, 'type' => 'non-consumable'],
            ['name' => 'Vacuum Cleaner',               'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 6,   'min' => 2,  'unit' => 'pcs',     'price' => 180.00,'type' => 'non-consumable'],
            ['name' => 'Microfiber Cloths (Pack)',     'cat' => 'Detergents',       'dept' => 'Housekeeping',   'qty' => 50,  'min' => 10, 'unit' => 'packs',   'price' => 8.00,  'type' => 'consumable'],
            ['name' => 'Rubber Gloves (Pair)',         'cat' => 'Disinfectants',    'dept' => 'Housekeeping',   'qty' => 80,  'min' => 20, 'unit' => 'pairs',   'price' => 2.50,  'type' => 'consumable'],
            ['name' => 'Aprons',                       'cat' => 'Towels',           'dept' => 'Kitchen',        'qty' => 25,  'min' => 5,  'unit' => 'pcs',     'price' => 10.00, 'type' => 'non-consumable'],
            ['name' => 'Oven Mitts (Pair)',            'cat' => 'Towels',           'dept' => 'Kitchen',        'qty' => 20,  'min' => 4,  'unit' => 'pairs',   'price' => 8.00,  'type' => 'non-consumable'],
            ['name' => 'Cutting Board (Large)',        'cat' => 'Detergents',       'dept' => 'Kitchen',        'qty' => 10,  'min' => 2,  'unit' => 'pcs',     'price' => 22.00, 'type' => 'non-consumable'],
            ['name' => 'Food Storage Containers (Set)','cat' => 'Detergents',       'dept' => 'Kitchen',        'qty' => 15,  'min' => 3,  'unit' => 'sets',    'price' => 18.00, 'type' => 'non-consumable'],
            ['name' => 'Aluminum Foil (Roll)',         'cat' => 'Toilet Supplies',  'dept' => 'Kitchen',        'qty' => 30,  'min' => 8,  'unit' => 'rolls',   'price' => 4.00,  'type' => 'consumable'],
            ['name' => 'Cling Wrap (Roll)',            'cat' => 'Toilet Supplies',  'dept' => 'Kitchen',        'qty' => 30,  'min' => 8,  'unit' => 'rolls',   'price' => 3.50,  'type' => 'consumable'],
            ['name' => 'Disposable Gloves (Box)',      'cat' => 'Disinfectants',    'dept' => 'Kitchen',        'qty' => 40,  'min' => 10, 'unit' => 'boxes',   'price' => 7.00,  'type' => 'consumable'],
            ['name' => 'Name Tag Holders',             'cat' => 'Stationery',       'dept' => 'Front Desk',     'qty' => 50,  'min' => 10, 'unit' => 'pcs',     'price' => 1.50,  'type' => 'non-consumable'],
            ['name' => 'Key Holders (Wall Mount)',     'cat' => 'Hand Tools',       'dept' => 'Front Desk',     'qty' => 10,  'min' => 2,  'unit' => 'pcs',     'price' => 15.00, 'type' => 'non-consumable'],
            ['name' => 'Luggage Cart',                 'cat' => 'Hand Tools',       'dept' => 'Front Desk',     'qty' => 5,   'min' => 1,  'unit' => 'pcs',     'price' => 120.00,'type' => 'non-consumable'],
            ['name' => 'Umbrella Stand',               'cat' => 'Hand Tools',       'dept' => 'Front Desk',     'qty' => 4,   'min' => 1,  'unit' => 'pcs',     'price' => 35.00, 'type' => 'non-consumable'],
            ['name' => 'Extension Cord (5m)',          'cat' => 'Power Tools',      'dept' => 'Administration', 'qty' => 15,  'min' => 3,  'unit' => 'pcs',     'price' => 12.00, 'type' => 'non-consumable'],
            ['name' => 'Power Strip (6-outlet)',       'cat' => 'Power Tools',      'dept' => 'Administration', 'qty' => 12,  'min' => 3,  'unit' => 'pcs',     'price' => 18.00, 'type' => 'non-consumable'],
            ['name' => 'AA Batteries (Pack of 10)',    'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 30,  'min' => 8,  'unit' => 'packs',   'price' => 5.00,  'type' => 'consumable'],
            ['name' => 'AAA Batteries (Pack of 10)',   'cat' => 'Printer Supplies', 'dept' => 'Administration', 'qty' => 25,  'min' => 6,  'unit' => 'packs',   'price' => 5.00,  'type' => 'consumable'],
            ['name' => 'Cable Ties (Pack)',            'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 20,  'min' => 5,  'unit' => 'packs',   'price' => 3.00,  'type' => 'consumable'],
            ['name' => 'Duct Tape',                    'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 18,  'min' => 4,  'unit' => 'rolls',   'price' => 4.50,  'type' => 'consumable'],
            ['name' => 'WD-40 Lubricant (400ml)',      'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 15,  'min' => 4,  'unit' => 'cans',    'price' => 8.00,  'type' => 'consumable'],
            ['name' => 'Sandpaper Sheets (Pack)',      'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 25,  'min' => 6,  'unit' => 'packs',   'price' => 5.00,  'type' => 'consumable'],
            ['name' => 'Wall Paint (White, 4L)',       'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 10,  'min' => 2,  'unit' => 'cans',    'price' => 35.00, 'type' => 'consumable'],
            ['name' => 'Paint Roller Set',             'cat' => 'Hand Tools',       'dept' => 'Maintenance',    'qty' => 8,   'min' => 2,  'unit' => 'sets',    'price' => 14.00, 'type' => 'non-consumable'],
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
