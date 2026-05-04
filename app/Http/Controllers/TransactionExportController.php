<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use App\Models\BorrowedItem;
use Illuminate\Http\Request;

class TransactionExportController extends Controller
{
    /**
     * Helper method to create extra wide columns for maximum readability
     */
    private function createWideColumn($text, $width = 50)
    {
        $actualWidth = max($width, strlen($text) + 20);
        return str_pad($text, $actualWidth, ' ', STR_PAD_RIGHT);
    }

    /**
     * Helper method to get borrowed items data
     */
    private function getBorrowedItemsData()
    {
        $borrowedItems = BorrowedItem::with(['item.category', 'user'])
            ->get()
            ->map(function ($borrowedItem) {
                return (object)[
                    'item' => $borrowedItem->item,
                    'user' => $borrowedItem->user,
                    'quantity_borrowed' => $borrowedItem->quantity,
                    'borrowed_date' => $borrowedItem->borrowed_at,
                    'borrower_name' => $borrowedItem->borrower_name,
                    'borrower_department' => $borrowedItem->borrower_department,
                    'notes' => $borrowedItem->notes,
                    'reference_number' => $borrowedItem->reference_number,
                ];
            });

        return [
            'items' => $borrowedItems->sortByDesc('borrowed_date'),
            'total_borrowed' => $borrowedItems->sum('quantity_borrowed'),
            'active_borrowers' => $borrowedItems->unique('user.id')->count()
        ];
    }

    /**
     * Export comprehensive reports with beautiful design and extra wide columns
     */
    public function exportReports(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $dateLabel = $dateFrom || $dateTo ? " ({$dateFrom} to {$dateTo})" : '';
        $filename = 'Icon_Venue_Suites_Complete_Report_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($dateFrom, $dateTo) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            $dateRangeLabel = $dateFrom || $dateTo ? ' | Date Range: ' . ($dateFrom ?: 'All') . ' to ' . ($dateTo ?: 'All') : '';
            fputcsv($file, [$this->createWideColumn('🏢 ICON VENUE & SUITES - COMPREHENSIVE ANALYTICS REPORT', 150)]);
            fputcsv($file, [$this->createWideColumn('📊 Professional Business Intelligence Dashboard', 120)]);
            fputcsv($file, [$this->createWideColumn('📅 Generated: ' . date('F j, Y \a\t g:i A') . $dateRangeLabel, 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [$this->createWideColumn('💼 EXECUTIVE SUMMARY', 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            $borrowedItemsData = $this->getBorrowedItemsData();

            fputcsv($file, [
                $this->createWideColumn('📦 Total Transactions', 60),
                $this->createWideColumn('✅ ' . number_format(Transaction::count()), 40),
                $this->createWideColumn('🟢 System Active', 35)
            ]);
            fputcsv($file, [
                $this->createWideColumn('🏷️ Total Items', 60),
                $this->createWideColumn('📋 ' . number_format(Item::count()), 40),
                $this->createWideColumn('🟢 Well Managed', 35)
            ]);
            fputcsv($file, [
                $this->createWideColumn('💰 Total Inventory Value', 60),
                $this->createWideColumn('💵 PHP ' . number_format(\App\Models\Batch::where('status', 'active')->whereNotNull('unit_cost')->get()->sum(fn($b) => ($b->getCurrentBookValue() ?? $b->unit_cost) * $b->quantity), 2), 40),
                $this->createWideColumn('🟢 Tracked', 35)
            ]);
            fputcsv($file, [
                $this->createWideColumn('📤 Currently Borrowed Items', 60),
                $this->createWideColumn('🔄 ' . number_format($borrowedItemsData['total_borrowed']), 40),
                $this->createWideColumn('🟡 Active', 35)
            ]);
            fputcsv($file, [
                $this->createWideColumn('👥 Active Borrowers', 60),
                $this->createWideColumn('👤 ' . number_format($borrowedItemsData['active_borrowers']), 40),
                $this->createWideColumn('🟢 Engaged', 35)
            ]);

            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('─', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [$this->createWideColumn('📊 STOCK STATUS ANALYSIS', 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            $inStock = Item::where('quantity', '>', 0)->whereRaw('quantity > minimum_stock')->count();
            $lowStock = Item::where('quantity', '>', 0)->whereRaw('quantity <= minimum_stock')->count();
            $outOfStock = Item::where('quantity', 0)->count();

            fputcsv($file, [
                $this->createWideColumn('🟢 Items In Stock', 60),
                $this->createWideColumn(number_format($inStock), 40),
                $this->createWideColumn('Healthy', 35)
            ]);
            fputcsv($file, [
                $this->createWideColumn('🟡 Low Stock Items', 60),
                $this->createWideColumn(number_format($lowStock), 40),
                $this->createWideColumn('Needs Attention', 35)
            ]);
            fputcsv($file, [
                $this->createWideColumn('🔴 Out of Stock Items', 60),
                $this->createWideColumn(number_format($outOfStock), 40),
                $this->createWideColumn('Critical', 35)
            ]);

            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('─', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [$this->createWideColumn('🏆 TOP 10 MOST BORROWED ITEMS', 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [
                $this->createWideColumn('🏷️ Item Name', 50),
                $this->createWideColumn('📂 Category', 40),
                $this->createWideColumn('🔢 Times Borrowed', 25),
                $this->createWideColumn('📊 Total Quantity', 25),
                $this->createWideColumn('🎯 Popularity', 20)
            ]);

            $topBorrowedItems = Transaction::selectRaw('transactions.item_id, items.name, categories.name as category_name, COUNT(*) as borrow_count, SUM(transactions.quantity) as total_borrowed')
                ->join('items', 'transactions.item_id', '=', 'items.id')
                ->join('categories', 'items.category_id', '=', 'categories.id')
                ->where('transaction_type', 'borrow')
                ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
                ->groupBy('transactions.item_id', 'items.name', 'categories.name')
                ->orderBy('total_borrowed', 'desc')
                ->limit(10)
                ->get();

            foreach ($topBorrowedItems as $index => $item) {
                $popularity = $index < 3 ? '🔥 High' : ($index < 7 ? '📈 Medium' : '📊 Normal');
                fputcsv($file, [
                    $this->createWideColumn($item->name, 50),
                    $this->createWideColumn($item->category_name, 40),
                    $this->createWideColumn(number_format($item->borrow_count), 25),
                    $this->createWideColumn(number_format($item->total_borrowed), 25),
                    $this->createWideColumn($popularity, 20)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('─', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [$this->createWideColumn('⏰ RECENT ACTIVITY (Last 10 Transactions)', 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [
                $this->createWideColumn('📅 Date', 25),
                $this->createWideColumn('🕐 Time', 15),
                $this->createWideColumn('🏷️ Item', 40),
                $this->createWideColumn('📂 Category', 35),
                $this->createWideColumn('🔄 Type', 25),
                $this->createWideColumn('👤 Staff', 30),
                $this->createWideColumn('🔢 Qty', 15)
            ]);

            $recentTransactions = Transaction::with(['item' => fn($q) => $q->withTrashed()->with('category'), 'user'])
                ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
                ->orderBy('transaction_date', 'desc')
                ->limit(10)
                ->get();

            foreach ($recentTransactions as $transaction) {
                fputcsv($file, [
                    $this->createWideColumn($transaction->transaction_date->format('Y-m-d'), 25),
                    $this->createWideColumn($transaction->transaction_date->format('H:i'), 15),
                    $this->createWideColumn($transaction->item->name, 40),
                    $this->createWideColumn($transaction->item->category->name, 35),
                    $this->createWideColumn(ucfirst(str_replace('_', ' ', $transaction->transaction_type)), 25),
                    $this->createWideColumn($transaction->user->name, 30),
                    $this->createWideColumn(number_format($transaction->quantity), 15)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            // COMPLETE TRANSACTION HISTORY SECTION
            fputcsv($file, [$this->createWideColumn('📋 COMPLETE TRANSACTION HISTORY', 120)]);
            fputcsv($file, [$this->createWideColumn('📊 All System Transactions - Chronological Order', 100)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);

            fputcsv($file, [
                $this->createWideColumn('📅 Date', 35),
                $this->createWideColumn('🕐 Time', 25),
                $this->createWideColumn('🏷️ Item Name', 70),
                $this->createWideColumn('📂 Category', 40),
                $this->createWideColumn('↔️ Direction', 25),
                $this->createWideColumn('🔄 Type', 35),
                $this->createWideColumn('🔢 Qty', 25),
                $this->createWideColumn('📏 Unit', 25),
                $this->createWideColumn('👤 Staff', 40),
                $this->createWideColumn('📝 Notes', 70),
                $this->createWideColumn('🔖 Ref#', 30)
            ]);

            $allTransactions = Transaction::with(['item' => fn($q) => $q->withTrashed()->with('category'), 'user'])
                ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
                ->orderBy('transaction_date', 'desc')->get();

            foreach ($allTransactions as $transaction) {
                fputcsv($file, [
                    $this->createWideColumn($transaction->transaction_date->format('Y-m-d'), 35),
                    $this->createWideColumn($transaction->transaction_date->format('H:i'), 25),
                    $this->createWideColumn($transaction->item->name, 70),
                    $this->createWideColumn($transaction->item->category->name, 40),
                    $this->createWideColumn($transaction->type === 'in' ? '📥 IN' : '📤 OUT', 25),
                    $this->createWideColumn(ucfirst(str_replace('_', ' ', $transaction->transaction_type)), 35),
                    $this->createWideColumn(number_format($transaction->quantity), 25),
                    $this->createWideColumn($transaction->item->unit, 25),
                    $this->createWideColumn($transaction->user->name, 40),
                    $this->createWideColumn($transaction->notes ?: 'No notes', 70),
                    $this->createWideColumn($transaction->reference_number ?: 'N/A', 30)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 180)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 180), 180)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);

            // COMPLETE INVENTORY SECTION
            fputcsv($file, [$this->createWideColumn('📦 COMPLETE INVENTORY LISTING', 120)]);
            fputcsv($file, [$this->createWideColumn('📊 All Items with Stock Status & Valuation', 100)]);
            fputcsv($file, [$this->createWideColumn('💰 Total Value: PHP ' . number_format(\App\Models\Batch::where('status', 'active')->whereNotNull('unit_cost')->get()->sum(fn($b) => ($b->getCurrentBookValue() ?? $b->unit_cost) * $b->quantity), 2), 100)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);

            fputcsv($file, [
                $this->createWideColumn('🏷️ Item Name', 70),
                $this->createWideColumn('📂 Category', 35),
                $this->createWideColumn('📊 Stock', 30),
                $this->createWideColumn('⚠️ Min', 25),
                $this->createWideColumn('📏 Unit', 25),
                $this->createWideColumn('🔄 Status', 30),
                $this->createWideColumn('📍 Location', 45),
                $this->createWideColumn('💰 Price', 30),
                $this->createWideColumn('💵 Value', 35),
                $this->createWideColumn('🎯 Health', 35)
            ]);

            $allItems = Item::with(['category', 'batch'])->orderBy('name')->get();

            foreach ($allItems as $item) {
                $stockHealth = '🟢 Healthy';
                if ($item->quantity == 0) {
                    $stockHealth = '🔴 OUT OF STOCK';
                } elseif ($item->quantity <= $item->minimum_stock) {
                    $stockHealth = '🟡 LOW STOCK';
                }

                $batchValue = $item->batch ? ($item->batch->getCurrentBookValue() ?? $item->batch->unit_cost) : null;
                $unitPrice = $batchValue ?? $item->unit_price ?? 0;
                $itemValue = $unitPrice * $item->quantity;

                fputcsv($file, [
                    $this->createWideColumn($item->name, 70),
                    $this->createWideColumn($item->category->name, 35),
                    $this->createWideColumn(number_format($item->quantity), 30),
                    $this->createWideColumn(number_format($item->minimum_stock), 25),
                    $this->createWideColumn($item->unit, 25),
                    $this->createWideColumn(ucfirst(str_replace('_', ' ', $item->status)), 30),
                    $this->createWideColumn($item->location ?: 'Not specified', 45),
                    $this->createWideColumn('PHP ' . number_format($unitPrice, 2), 30),
                    $this->createWideColumn('PHP ' . number_format($itemValue, 2), 35),
                    $this->createWideColumn($stockHealth, 35)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 180)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 180), 180)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);

            // COMPLETE BORROWED ITEMS SECTION
            fputcsv($file, [$this->createWideColumn('📤 COMPLETE BORROWED ITEMS TRACKING', 120)]);
            fputcsv($file, [$this->createWideColumn('📊 All Currently Borrowed Items with Status', 100)]);
            fputcsv($file, [$this->createWideColumn('📊 Total Borrowed: ' . number_format($borrowedItemsData['total_borrowed']), 90)]);
            fputcsv($file, [$this->createWideColumn('👥 Active Borrowers: ' . number_format($borrowedItemsData['active_borrowers']), 90)]);
            fputcsv($file, [$this->createWideColumn('', 220)]);

            if ($borrowedItemsData['items']->count() > 0) {
                fputcsv($file, [
                    $this->createWideColumn('🏷️ Item Name', 65),
                    $this->createWideColumn('📂 Category', 35),
                    $this->createWideColumn('👤 Borrower', 45),
                    $this->createWideColumn('🏢 Department', 40),
                    $this->createWideColumn('🔢 Qty', 25),
                    $this->createWideColumn('📏 Unit', 25),
                    $this->createWideColumn('📅 Date', 30),
                    $this->createWideColumn('🕐 Time', 22),
                    $this->createWideColumn('⏰ Days', 25),
                    $this->createWideColumn('🎯 Status', 30),
                    $this->createWideColumn('👨‍💼 Staff', 35),
                    $this->createWideColumn('🔖 Ref#', 30),
                    $this->createWideColumn('📝 Notes', 60)
                ]);

                foreach ($borrowedItemsData['items'] as $borrowed) {
                    $daysOut = now()->diffInDays($borrowed->borrowed_date);
                    $status = $daysOut > 30 ? '🔴 OVERDUE' : ($daysOut > 14 ? '🟡 LONG TERM' : '🟢 NORMAL');

                    fputcsv($file, [
                        $this->createWideColumn($borrowed->item->name, 65),
                        $this->createWideColumn($borrowed->item->category->name, 35),
                        $this->createWideColumn($borrowed->borrower_name ?: $borrowed->user->name, 45),
                        $this->createWideColumn($borrowed->borrower_department ?: ($borrowed->user->department ?: 'Not specified'), 40),
                        $this->createWideColumn(number_format($borrowed->quantity_borrowed), 25),
                        $this->createWideColumn($borrowed->item->unit, 25),
                        $this->createWideColumn($borrowed->borrowed_date->format('Y-m-d'), 30),
                        $this->createWideColumn($borrowed->borrowed_date->format('H:i'), 22),
                        $this->createWideColumn($daysOut . ' days', 25),
                        $this->createWideColumn($status, 30),
                        $this->createWideColumn($borrowed->user->name, 35),
                        $this->createWideColumn($borrowed->reference_number ?: 'N/A', 30),
                        $this->createWideColumn($borrowed->notes ?: 'No notes', 60)
                    ]);
                }
            } else {
                fputcsv($file, [$this->createWideColumn('🎉 EXCELLENT NEWS! No items currently borrowed.', 120)]);
                fputcsv($file, [$this->createWideColumn('✅ All inventory items have been returned.', 100)]);
            }

            fputcsv($file, [$this->createWideColumn('', 220)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 220), 220)]);
            fputcsv($file, [$this->createWideColumn('🏁 END OF COMPREHENSIVE REPORT', 100)]);
            fputcsv($file, [$this->createWideColumn('📊 Generated by Icon Venue & Suites Management System', 120)]);
            fputcsv($file, [$this->createWideColumn('🎯 Complete Business Intelligence & Analytics Dashboard', 120)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export transactions with beautiful design and extra wide columns
     */
    public function exportTransactions(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $filename = 'Icon_Venue_Suites_Transactions_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($dateFrom, $dateTo) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            $dateRangeLabel = $dateFrom || $dateTo ? ' | ' . ($dateFrom ?: 'All') . ' to ' . ($dateTo ?: 'All') : '';
            fputcsv($file, [$this->createWideColumn('🏢 ICON VENUE & SUITES', 120)]);
            fputcsv($file, [$this->createWideColumn('📋 TRANSACTION HISTORY - PROFESSIONAL EDITION', 150)]);
            fputcsv($file, [$this->createWideColumn('📅 Generated: ' . date('F j, Y \a\t g:i A') . $dateRangeLabel, 100)]);
            fputcsv($file, [$this->createWideColumn('📊 Total: ' . number_format(Transaction::count()) . ' Transactions', 90)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 180), 180)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);

            fputcsv($file, [
                $this->createWideColumn('📅 Date', 30),
                $this->createWideColumn('🕐 Time', 20),
                $this->createWideColumn('🏷️ Item Name', 50),
                $this->createWideColumn('📂 Category', 40),
                $this->createWideColumn('↔️ Direction', 20),
                $this->createWideColumn('🔄 Type', 30),
                $this->createWideColumn('🔢 Qty', 20),
                $this->createWideColumn('📏 Unit', 20),
                $this->createWideColumn('👤 Staff', 35),
                $this->createWideColumn('📝 Notes', 50),
                $this->createWideColumn('🔖 Ref#', 25)
            ]);

            $transactions = Transaction::with(['item' => fn($q) => $q->withTrashed()->with('category'), 'user'])
                ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
                ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
                ->orderBy('transaction_date', 'desc')->get();

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $this->createWideColumn($transaction->transaction_date->format('Y-m-d'), 30),
                    $this->createWideColumn($transaction->transaction_date->format('H:i'), 20),
                    $this->createWideColumn($transaction->item->name, 50),
                    $this->createWideColumn($transaction->item->category->name, 40),
                    $this->createWideColumn($transaction->type === 'in' ? '📥 IN' : '📤 OUT', 20),
                    $this->createWideColumn(ucfirst(str_replace('_', ' ', $transaction->transaction_type)), 30),
                    $this->createWideColumn(number_format($transaction->quantity), 20),
                    $this->createWideColumn($transaction->item->unit, 20),
                    $this->createWideColumn($transaction->user->name, 35),
                    $this->createWideColumn($transaction->notes ?: 'No notes', 50),
                    $this->createWideColumn($transaction->reference_number ?: 'N/A', 25)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 180)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 180), 180)]);
            fputcsv($file, [$this->createWideColumn('🏁 END OF TRANSACTION REPORT', 100)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export inventory with beautiful design and extra wide columns
     */
    public function exportInventory(Request $request)
    {
        $filename = 'Icon_Venue_Suites_Inventory_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [$this->createWideColumn('🏢 ICON VENUE & SUITES', 120)]);
            fputcsv($file, [$this->createWideColumn('📦 INVENTORY REPORT - PROFESSIONAL EDITION', 150)]);
            fputcsv($file, [$this->createWideColumn('📅 Generated: ' . date('F j, Y \a\t g:i A'), 100)]);
            fputcsv($file, [$this->createWideColumn('📊 Total Items: ' . number_format(Item::count()), 80)]);
            fputcsv($file, [$this->createWideColumn('💰 Total Value: PHP ' . number_format(\App\Models\Batch::where('status', 'active')->whereNotNull('unit_cost')->get()->sum(fn($b) => ($b->getCurrentBookValue() ?? $b->unit_cost) * $b->quantity), 2), 100)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 180), 180)]);
            fputcsv($file, [$this->createWideColumn('', 180)]);

            fputcsv($file, [
                $this->createWideColumn('🏷️ Item Name', 70),
                $this->createWideColumn('📂 Category', 45),
                $this->createWideColumn('📊 Stock', 30),
                $this->createWideColumn('⚠️ Min', 25),
                $this->createWideColumn('📏 Unit', 25),
                $this->createWideColumn('🔄 Status', 30),
                $this->createWideColumn('📍 Location', 45),
                $this->createWideColumn('💰 Price', 30),
                $this->createWideColumn('💵 Value', 35),
                $this->createWideColumn('🎯 Health', 35)
            ]);

            $items = Item::with(['category', 'batch'])->orderBy('name')->get();

            foreach ($items as $item) {
                $stockHealth = '🟢 Healthy';
                if ($item->quantity == 0) {
                    $stockHealth = '🔴 OUT OF STOCK';
                } elseif ($item->quantity <= $item->minimum_stock) {
                    $stockHealth = '🟡 LOW STOCK';
                }

                $batchValue = $item->batch ? ($item->batch->getCurrentBookValue() ?? $item->batch->unit_cost) : null;
                $unitPrice = $batchValue ?? $item->unit_price ?? 0;
                $itemValue = $unitPrice * $item->quantity;

                fputcsv($file, [
                    $this->createWideColumn($item->name, 70),
                    $this->createWideColumn($item->category->name, 45),
                    $this->createWideColumn(number_format($item->quantity), 30),
                    $this->createWideColumn(number_format($item->minimum_stock), 25),
                    $this->createWideColumn($item->unit, 25),
                    $this->createWideColumn(ucfirst(str_replace('_', ' ', $item->status)), 30),
                    $this->createWideColumn($item->location ?: 'Not specified', 45),
                    $this->createWideColumn('PHP ' . number_format($unitPrice, 2), 30),
                    $this->createWideColumn('PHP ' . number_format($itemValue, 2), 35),
                    $this->createWideColumn($stockHealth, 35)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 180)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 180), 180)]);
            fputcsv($file, [$this->createWideColumn('🏁 END OF INVENTORY REPORT', 100)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export borrowed items with beautiful design and extra wide columns
     */
    public function exportBorrowedItems(Request $request)
    {
        $filename = 'Icon_Venue_Suites_Borrowed_Items_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [$this->createWideColumn('🏢 ICON VENUE & SUITES', 120)]);
            fputcsv($file, [$this->createWideColumn('📤 BORROWED ITEMS - PROFESSIONAL EDITION', 150)]);
            fputcsv($file, [$this->createWideColumn('📅 Generated: ' . date('F j, Y \a\t g:i A'), 100)]);

            $borrowedItemsData = $this->getBorrowedItemsData();
            fputcsv($file, [$this->createWideColumn('📊 Total Borrowed: ' . number_format($borrowedItemsData['total_borrowed']), 90)]);
            fputcsv($file, [$this->createWideColumn('👥 Active Borrowers: ' . number_format($borrowedItemsData['active_borrowers']), 90)]);
            fputcsv($file, [$this->createWideColumn('', 220)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 220), 220)]);
            fputcsv($file, [$this->createWideColumn('', 220)]);

            if ($borrowedItemsData['items']->count() > 0) {
                fputcsv($file, [
                    $this->createWideColumn('🏷️ Item Name', 65),
                    $this->createWideColumn('📂 Category', 45),
                    $this->createWideColumn('👤 Borrower', 45),
                    $this->createWideColumn('🏢 Department', 40),
                    $this->createWideColumn('🔢 Qty', 25),
                    $this->createWideColumn('📏 Unit', 25),
                    $this->createWideColumn('📅 Date', 30),
                    $this->createWideColumn('🕐 Time', 22),
                    $this->createWideColumn('⏰ Days', 25),
                    $this->createWideColumn('🎯 Status', 30),
                    $this->createWideColumn('👨‍💼 Staff', 35),
                    $this->createWideColumn('🔖 Ref#', 30),
                    $this->createWideColumn('📝 Notes', 60)
                ]);

                foreach ($borrowedItemsData['items'] as $borrowed) {
                    $daysOut = now()->diffInDays($borrowed->borrowed_date);
                    $status = $daysOut > 30 ? '🔴 OVERDUE' : ($daysOut > 14 ? '🟡 LONG TERM' : '🟢 NORMAL');

                    fputcsv($file, [
                        $this->createWideColumn($borrowed->item->name, 65),
                        $this->createWideColumn($borrowed->item->category->name, 45),
                        $this->createWideColumn($borrowed->borrower_name ?: $borrowed->user->name, 45),
                        $this->createWideColumn($borrowed->borrower_department ?: ($borrowed->user->department ?: 'Not specified'), 40),
                        $this->createWideColumn(number_format($borrowed->quantity_borrowed), 25),
                        $this->createWideColumn($borrowed->item->unit, 25),
                        $this->createWideColumn($borrowed->borrowed_date->format('Y-m-d'), 30),
                        $this->createWideColumn($borrowed->borrowed_date->format('H:i'), 22),
                        $this->createWideColumn($daysOut . ' days', 25),
                        $this->createWideColumn($status, 30),
                        $this->createWideColumn($borrowed->user->name, 35),
                        $this->createWideColumn($borrowed->reference_number ?: 'N/A', 30),
                        $this->createWideColumn($borrowed->notes ?: 'No notes', 60)
                    ]);
                }
            } else {
                fputcsv($file, [$this->createWideColumn('🎉 EXCELLENT NEWS! No items currently borrowed.', 120)]);
                fputcsv($file, [$this->createWideColumn('✅ All inventory items have been returned.', 100)]);
            }

            fputcsv($file, [$this->createWideColumn('', 220)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 220), 220)]);
            fputcsv($file, [$this->createWideColumn('🏁 END OF BORROWED ITEMS REPORT', 100)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
