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
        Schema::table('items', function (Blueprint $table) {
            // First, update items to use the recursive category system
            // Move items from subcategories to their parent categories if needed
            $this->migrateSubcategoryItems();
            
            // Drop the foreign key constraint first
            $table->dropForeign(['subcategory_id']);
            // Then drop the column
            $table->dropColumn('subcategory_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
        });
    }

    /**
     * Migrate items from subcategories to recursive categories
     */
    private function migrateSubcategoryItems()
    {
        // This method will handle the migration of existing subcategory data
        // For now, we'll keep items in their current categories
        // In a real migration, you might want to create child categories from subcategories
    }
};