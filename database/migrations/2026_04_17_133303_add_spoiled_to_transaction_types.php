<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN transaction_type ENUM('borrow', 'return', 'replenish', 'disposal', 'recovered', 'spoiled') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN transaction_type ENUM('borrow', 'return', 'replenish', 'disposal', 'recovered') NOT NULL");
    }
};
