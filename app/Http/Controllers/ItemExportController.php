<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemExportController extends Controller
{
    /**
     * Export item transaction history to CSV with beautiful formatting
     */
    public function exportTransactions(Item $item, Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $transactions = $item->transactions()
            ->with('user')
            ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
            ->orderBy('transaction_date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $filename = 'Icon_Venue_Suites_' . str_replace(' ', '_', $item->name) . '_Transaction_History_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions, $item) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [$this->createWideColumn('🏢 ICON VENUE & SUITES - ITEM TRANSACTION HISTORY', 150)]);
            fputcsv($file, [$this->createWideColumn('📦 Detailed Transaction Report', 120)]);
            fputcsv($file, [$this->createWideColumn('📅 Generated: ' . date('F j, Y \a\t g:i A'), 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [$this->createWideColumn('📋 ITEM INFORMATION', 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [
                $this->createWideColumn('🏷️ Item Name', 50),
                $this->createWideColumn($item->name, 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('📂 Category', 50),
                $this->createWideColumn($item->category->path ?: $item->category->name, 100)
            ]);
            if ($item->department) {
                fputcsv($file, [
                    $this->createWideColumn('🏢 Department', 50),
                    $this->createWideColumn($item->department->name, 100)
                ]);
            }
            fputcsv($file, [
                $this->createWideColumn('📊 Current Stock', 50),
                $this->createWideColumn($item->quantity . ' ' . $item->unit, 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('⚠️ Minimum Stock', 50),
                $this->createWideColumn($item->minimum_stock . ' ' . $item->unit, 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('🔄 Currently Borrowed', 50),
                $this->createWideColumn($item->borrowed_quantity . ' ' . $item->unit, 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('📦 Total Item Stock', 50),
                $this->createWideColumn(($item->quantity + $item->borrowed_quantity) . ' ' . $item->unit, 100)
            ]);
            if ($item->unit_price) {
                fputcsv($file, [
                    $this->createWideColumn('💰 Unit Price', 50),
                    $this->createWideColumn('PHP ' . number_format($item->unit_price, 2), 100)
                ]);
                fputcsv($file, [
                    $this->createWideColumn('💵 Total Value', 50),
                    $this->createWideColumn('PHP ' . number_format($item->quantity * $item->unit_price, 2), 100)
                ]);
            }
            fputcsv($file, [
                $this->createWideColumn('📍 Status', 50),
                $this->createWideColumn(ucfirst(str_replace('_', ' ', $item->status)), 100)
            ]);
            if ($item->location) {
                fputcsv($file, [
                    $this->createWideColumn('📌 Location', 50),
                    $this->createWideColumn($item->location, 100)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('─', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [$this->createWideColumn('📊 TRANSACTION STATISTICS', 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            $totalIn = $transactions->where('type', 'in')->sum('quantity');
            $totalOut = $transactions->where('type', 'out')->sum('quantity');
            $borrowCount = $transactions->where('transaction_type', 'borrow')->count();
            $returnCount = $transactions->where('transaction_type', 'return')->count();

            fputcsv($file, [
                $this->createWideColumn('📥 Total Items In', 50),
                $this->createWideColumn(number_format($totalIn) . ' ' . $item->unit, 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('📤 Total Items Out', 50),
                $this->createWideColumn(number_format($totalOut) . ' ' . $item->unit, 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('🔄 Total Borrow Transactions', 50),
                $this->createWideColumn(number_format($borrowCount), 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('↩️ Total Return Transactions', 50),
                $this->createWideColumn(number_format($returnCount), 100)
            ]);
            fputcsv($file, [
                $this->createWideColumn('📋 Total Transactions', 50),
                $this->createWideColumn(number_format($transactions->count()), 100)
            ]);

            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('─', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [$this->createWideColumn('📜 COMPLETE TRANSACTION HISTORY', 100)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);

            fputcsv($file, [
                $this->createWideColumn('📅 Date & Time', 25),
                $this->createWideColumn('🔖 Reference', 20),
                $this->createWideColumn('🏷️ Type', 20),
                $this->createWideColumn('📊 Quantity', 18),
                $this->createWideColumn('📉 Previous Stock', 20),
                $this->createWideColumn('📈 Total Stock', 20),
                $this->createWideColumn('👤 User', 25),
                $this->createWideColumn('📝 Notes', 40)
            ]);

            $runningStock = $item->quantity;
            $stockLevels = [];

            foreach (array_reverse($transactions->toArray()) as $trans) {
                $stockAfter = $runningStock;
                if ($trans['type'] === 'in') {
                    $runningStock -= $trans['quantity'];
                } else {
                    $runningStock += $trans['quantity'];
                }
                $stockBefore = $runningStock;

                $stockLevels[$trans['id']] = [
                    'before' => $stockBefore,
                    'after' => $stockAfter
                ];
            }

            foreach ($transactions as $transaction) {
                $typeIcon = $transaction->type === 'in' ? '📥' : '📤';
                $transactionTypeFormatted = ucfirst(str_replace('_', ' ', $transaction->transaction_type));

                fputcsv($file, [
                    $this->createWideColumn($transaction->transaction_date->format('M d, Y h:i A'), 25),
                    $this->createWideColumn($transaction->reference_number ?? 'N/A', 20),
                    $this->createWideColumn($typeIcon . ' ' . $transactionTypeFormatted, 20),
                    $this->createWideColumn(number_format($transaction->quantity) . ' ' . $item->unit, 18),
                    $this->createWideColumn(number_format($stockLevels[$transaction->id]['before']) . ' ' . $item->unit, 20),
                    $this->createWideColumn(number_format($stockLevels[$transaction->id]['after']) . ' ' . $item->unit, 20),
                    $this->createWideColumn($transaction->user->name ?? 'N/A', 25),
                    $this->createWideColumn($transaction->notes ?? '', 40)
                ]);
            }

            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn(str_repeat('═', 150), 150)]);
            fputcsv($file, [$this->createWideColumn('', 150)]);
            fputcsv($file, [$this->createWideColumn('✅ End of Report - Generated by Icon Venue & Suites Inventory Management System', 150)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper function to create wide columns for better CSV formatting
     */
    private function createWideColumn($text, $width = 50)
    {
        return str_pad($text, $width, ' ', STR_PAD_RIGHT);
    }
}
