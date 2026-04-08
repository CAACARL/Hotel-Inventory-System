<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create sample transactions with all required types
        $transactions = [
            [
                'item_id' => 1,
                'user_id' => 1,
                'type' => 'in',
                'transaction_type' => 'delivery',
                'quantity' => 20,
                'notes' => 'Initial stock delivery',
                'reference_number' => 'DEL-001',
                'transaction_date' => now()->subDays(10),
            ],
            [
                'item_id' => 2,
                'user_id' => 1,
                'type' => 'in',
                'transaction_type' => 'recovered',
                'quantity' => 3,
                'notes' => 'Recovered from damaged items after repair',
                'reference_number' => 'REC-001',
                'transaction_date' => now()->subDays(8),
            ],
            [
                'item_id' => 3,
                'user_id' => 2,
                'type' => 'out',
                'transaction_type' => 'disposal',
                'quantity' => 2,
                'notes' => 'Disposed due to irreparable damage',
                'reference_number' => 'DIS-001',
                'transaction_date' => now()->subDays(7),
            ],
            [
                'item_id' => 2,
                'user_id' => 2,
                'type' => 'out',
                'transaction_type' => 'borrow',
                'quantity' => 5,
                'notes' => 'For room 101-105 cleaning',
                'reference_number' => 'BOR-001',
                'transaction_date' => now()->subDays(5),
            ],
            [
                'item_id' => 3,
                'user_id' => 2,
                'type' => 'out',
                'transaction_type' => 'issue',
                'quantity' => 2,
                'notes' => 'Housekeeping department supply',
                'reference_number' => 'ISS-001',
                'transaction_date' => now()->subDays(3),
            ],
            [
                'item_id' => 2,
                'user_id' => 2,
                'type' => 'in',
                'transaction_type' => 'return',
                'quantity' => 3,
                'notes' => 'Returned after cleaning',
                'reference_number' => 'RET-001',
                'transaction_date' => now()->subDays(2),
            ],
            [
                'item_id' => 4,
                'user_id' => 1,
                'type' => 'in',
                'transaction_type' => 'delivery',
                'quantity' => 50,
                'notes' => 'Weekly toilet paper delivery',
                'reference_number' => 'DEL-002',
                'transaction_date' => now()->subDay(),
            ],
            [
                'item_id' => 1,
                'user_id' => 2,
                'type' => 'out',
                'transaction_type' => 'borrow',
                'quantity' => 10,
                'notes' => 'For VIP suite preparation',
                'reference_number' => 'BOR-002',
                'transaction_date' => now()->subHours(6),
            ],
            [
                'item_id' => 5,
                'user_id' => 1,
                'type' => 'out',
                'transaction_type' => 'issue',
                'quantity' => 1,
                'notes' => 'Maintenance department tool issue',
                'reference_number' => 'ISS-002',
                'transaction_date' => now()->subHours(2),
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::create($transaction);
        }
    }
}