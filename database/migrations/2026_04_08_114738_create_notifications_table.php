<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // low_stock, expiring, expired, overdue_borrow, new_borrow, borrowed_item
            $table->string('title');
            $table->string('description');
            $table->string('url');
            $table->string('icon')->default('bell'); // warning, clock, x, borrow
            $table->string('color')->default('blue'); // yellow, orange, red, blue
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
