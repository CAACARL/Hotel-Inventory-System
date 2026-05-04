<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->decimal('purchase_price', 10, 2)->nullable()->after('unit_cost');
            $table->date('purchase_date')->nullable()->after('purchase_price');
            $table->string('depreciation_method')->default('none')->after('purchase_date');
            $table->integer('useful_life_years')->nullable()->after('depreciation_method');
            $table->decimal('salvage_value', 10, 2)->nullable()->after('useful_life_years');
            $table->decimal('depreciation_rate', 5, 2)->nullable()->after('salvage_value');
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn([
                'purchase_price', 'purchase_date', 'depreciation_method',
                'useful_life_years', 'salvage_value', 'depreciation_rate',
            ]);
        });
    }
};
