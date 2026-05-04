<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Remove 'recovered' from transactions.transaction_type
        DB::statement("ALTER TABLE transactions MODIFY COLUMN transaction_type ENUM('borrow','return','replenish','disposal','spoiled') NOT NULL");

        // Remove 'recalled' and 'depleted' from batches.status
        DB::statement("ALTER TABLE batches MODIFY COLUMN status ENUM('active','expired') NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN transaction_type ENUM('borrow','return','replenish','disposal','recovered','spoiled') NOT NULL");
        DB::statement("ALTER TABLE batches MODIFY COLUMN status ENUM('active','expired','recalled','depleted') NOT NULL DEFAULT 'active'");
    }
};
