<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use App\Models\Batch;

class CheckExpiredConsumables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consumables:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired consumable items and mark them as spoiled';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired consumable batches...');

        // Get all expired batches for consumable items that are still marked as active
        $expiredBatches = Batch::where('status', 'active')
            ->where('expiry_date', '<', now())
            ->whereHas('item', function($query) {
                $query->where('item_type', 'consumable');
            })
            ->with('item')
            ->get();

        $processedCount = 0;
        $totalQuantityDeducted = 0;

        foreach ($expiredBatches as $batch) {
            $item = $batch->item;
            $batchQuantity = $batch->quantity;

            // Mark batch as expired and deduct quantity
            if ($batch->markAsExpired()) {
                $processedCount++;
                $totalQuantityDeducted += $batchQuantity;
                
                $this->line("Expired batch: {$batch->batch_number} - {$item->name} ({$batchQuantity} {$item->unit} deducted)");
                
                if ($item->fresh()->status === 'spoiled') {
                    $this->line("  → Item marked as spoiled: {$item->name} (all stock expired)");
                }
            }
        }

        if ($processedCount > 0) {
            $this->info("Successfully processed {$processedCount} expired batch(es).");
            $this->info("Total quantity deducted: {$totalQuantityDeducted}");
        } else {
            $this->info('No expired consumable batches found.');
        }

        return 0;
    }
}
