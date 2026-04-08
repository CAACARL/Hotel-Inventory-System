<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update transaction_type column to include new types
        DB::statement("ALTER TABLE transactions MODIFY COLUMN transaction_type ENUM('delivery', 'borrow', 'return', 'issue', 'recovered', 'disposal') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE transactions MODIFY COLUMN transaction_type ENUM('delivery', 'borrow', 'return', 'issue') NOT NULL");
    }
};