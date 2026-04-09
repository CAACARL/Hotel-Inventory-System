<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemExportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionExportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified', 'two-factor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/trusted-device/{device}', [ProfileController::class, 'removeTrustedDevice'])->name('profile.remove-trusted-device');
    
    // Categories (Admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::post('/categories/{category}/subcategories', [CategoryController::class, 'storeSubcategory'])->name('categories.subcategories.store');
        Route::put('/subcategories/{subcategory}', [CategoryController::class, 'updateSubcategory'])->name('subcategories.update');
        Route::delete('/subcategories/{subcategory}', [CategoryController::class, 'destroySubcategory'])->name('subcategories.destroy');
        Route::get('/categories/{category}/subcategories', [CategoryController::class, 'getSubcategories'])->name('categories.subcategories.get');
        Route::get('/api/categories/hierarchy', [CategoryController::class, 'getCategoriesHierarchy']);
    });
    
    // Departments (Admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('departments', DepartmentController::class);
    });
    
    // Items - Staff can view and borrow/return, Admin can manage
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('/items/{item}/borrow', [ItemController::class, 'borrow'])->name('items.borrow');
    Route::post('/items/{item}/borrow', [ItemController::class, 'processBorrow'])->name('items.process-borrow');
    Route::get('/items/{item}/return', [ItemController::class, 'return'])->name('items.return');
    Route::post('/items/{item}/return', [ItemController::class, 'processReturn'])->name('items.process-return');
    Route::get('/items/{item}/transactions/export', [ItemExportController::class, 'exportTransactions'])->name('items.transactions.export');
    
    // Items management (Admin only)
    Route::middleware(['admin'])->group(function () {
        Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
        Route::post('/items', [ItemController::class, 'store'])->name('items.store');
        Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::post('/items/{item}/replenish', [ItemController::class, 'processReplenish'])->name('items.process-replenish');
        Route::post('/items/{item}/recovered', [ItemController::class, 'markRecovered'])->name('items.mark-recovered');
        Route::post('/items/{item}/disposal', [ItemController::class, 'markDisposal'])->name('items.mark-disposal');
    });

    // Borrowed items — accessible by all authenticated users
    Route::get('/borrowed-items', [ItemController::class, 'borrowedItems'])->name('items.borrowed');
    
    // Batch Management (Admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('batches', \App\Http\Controllers\BatchController::class);
        Route::post('/batches/{batch}/mark-expired', [\App\Http\Controllers\BatchController::class, 'markExpired'])->name('batches.mark-expired');
    });
    
    // Reports and Transactions
    Route::middleware(['admin'])->group(function () {
        Route::get('/reports', [TransactionController::class, 'reports'])->name('reports');
        Route::get('/reports/export', [TransactionExportController::class, 'exportReports'])->name('reports.export');
        Route::get('/transactions/export', [TransactionExportController::class, 'exportTransactions'])->name('transactions.export');
        Route::get('/inventory/export', [TransactionExportController::class, 'exportInventory'])->name('inventory.export');
        Route::get('/borrowed-items/export', [TransactionExportController::class, 'exportBorrowedItems'])->name('borrowed-items.export');
        Route::post('/transactions/clear-history', [TransactionController::class, 'clearHistory'])->name('transactions.clear-history');
        Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    });
    
    // Users (Admin only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
