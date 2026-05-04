<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('available', 'in_use', 'disposed', 'spoiled') DEFAULT 'available'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE items MODIFY COLUMN status ENUM('available', 'in_use', 'spoiled') DEFAULT 'available'");
    }
};
