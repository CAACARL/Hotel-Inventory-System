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
        // Add batch_id to transactions table for tracking which batch was used
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->after('item_id')->constrained()->onDelete('set null');
        });

        // Modify borrowed_items to track batch-level borrows
        Schema::dropIfExists('borrowed_items');
        
        Schema::create('borrowed_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('borrower_name')->nullable();
            $table->string('borrower_department')->nullable();
            $table->text('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->timestamp('borrowed_at');
            $table->timestamps();
            
            // Allow multiple borrows from different batches by same user
            $table->unique(['item_id', 'batch_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });

        // Revert borrowed_items to original structure
        Schema::dropIfExists('borrowed_items');
        
        Schema::create('borrowed_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('borrower_name')->nullable();
            $table->string('borrower_department')->nullable();
            $table->text('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->timestamp('borrowed_at');
            $table->timestamps();
            
            $table->unique(['item_id', 'user_id']);
        });
    }
};
