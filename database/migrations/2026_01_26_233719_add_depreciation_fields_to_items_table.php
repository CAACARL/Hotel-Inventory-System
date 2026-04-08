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
            $table->decimal('purchase_price', 10, 2)->nullable()->after('unit_price');
            $table->date('purchase_date')->nullable()->after('purchase_price');
            $table->integer('useful_life_years')->nullable()->after('purchase_date')->comment('Expected useful life in years');
            $table->enum('depreciation_method', ['straight_line', 'declining_balance', 'none'])->default('straight_line')->after('useful_life_years');
            $table->decimal('salvage_value', 10, 2)->nullable()->after('depreciation_method')->comment('Expected value at end of useful life');
            $table->decimal('current_book_value', 10, 2)->nullable()->after('salvage_value')->comment('Current depreciated value');
            $table->decimal('accumulated_depreciation', 10, 2)->default(0)->after('current_book_value');
            $table->date('last_depreciation_date')->nullable()->after('accumulated_depreciation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                'purchase_price',
                'purchase_date',
                'useful_life_years',
                'depreciation_method',
                'salvage_value',
                'current_book_value',
                'accumulated_depreciation',
                'last_depreciation_date'
            ]);
        });
    }
};