<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Reassign any existing damaged/disposed items to available before removing the enum values
        DB::statement("UPDATE items SET status = 'available' WHERE status IN ('damaged', 'disposed')");
        DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('available', 'in_use', 'spoiled') DEFAULT 'available'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('available', 'in_use', 'damaged', 'disposed', 'spoiled') DEFAULT 'available'");
    }
};
