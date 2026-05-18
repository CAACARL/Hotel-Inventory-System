<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add location to batches table
        Schema::table('batches', function (Blueprint $table) {
            $table->string('location')->nullable()->after('lot_number');
        });

        // Migrate existing location data from items to their batches
        DB::statement('
            UPDATE batches 
            SET location = (
                SELECT location 
                FROM items 
                WHERE items.id = batches.item_id
            )
            WHERE EXISTS (
                SELECT 1 
                FROM items 
                WHERE items.id = batches.item_id 
                AND items.location IS NOT NULL
            )
        ');

        // Remove location from items table
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add location back to items table
        Schema::table('items', function (Blueprint $table) {
            $table->string('location')->nullable()->after('status');
        });

        // Migrate location data back from batches to items (take first batch's location)
        DB::statement('
            UPDATE items 
            SET location = (
                SELECT location 
                FROM batches 
                WHERE batches.item_id = items.id 
                AND batches.location IS NOT NULL
                ORDER BY batches.id ASC
                LIMIT 1
            )
            WHERE EXISTS (
                SELECT 1 
                FROM batches 
                WHERE batches.item_id = items.id 
                AND batches.location IS NOT NULL
            )
        ');

        // Remove location from batches table
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
};
