<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                'purchase_price',
                'purchase_date',
                'useful_life_years',
                'depreciation_method',
                'depreciation_rate',
                'salvage_value',
                'current_book_value',
                'accumulated_depreciation',
                'last_depreciation_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->integer('useful_life_years')->nullable();
            $table->enum('depreciation_method', ['straight_line', 'declining_balance', 'none'])->default('straight_line');
            $table->decimal('depreciation_rate', 5, 2)->nullable();
            $table->decimal('salvage_value', 10, 2)->nullable();
            $table->decimal('current_book_value', 10, 2)->nullable();
            $table->decimal('accumulated_depreciation', 10, 2)->default(0);
            $table->date('last_depreciation_date')->nullable();
        });
    }
};
