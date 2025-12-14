<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Items
    Route::resource('items', ItemController::class);
    Route::get('/items/{item}/borrow', [ItemController::class, 'borrow'])->name('items.borrow');
    Route::post('/items/{item}/borrow', [ItemController::class, 'processBorrow'])->name('items.process-borrow');
    Route::get('/items/{item}/return', [ItemController::class, 'return'])->name('items.return');
    Route::post('/items/{item}/return', [ItemController::class, 'processReturn'])->name('items.process-return');
    
    // Transactions
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::get('/reports', [TransactionController::class, 'reports'])->name('reports');
    
    // Users (Admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
