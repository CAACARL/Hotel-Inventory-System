<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class UpdateDepreciation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'depreciation:update {--force : Force update all items regardless of last update date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update depreciation values for all items';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting depreciation update...');

        $query = Item::where('depreciation_method', '!=', 'none')
                    ->whereNotNull('purchase_date')
                    ->whereNotNull('purchase_price');

        if (!$this->option('force')) {
            $query->where(function ($q) {
                $q->whereNull('last_depreciation_date')
                  ->orWhere('last_depreciation_date', '<', now()->subMonth());
            });
        }

        $items = $query->get();

        if ($items->isEmpty()) {
            $this->info('No items need depreciation updates.');
            return;
        }

        $this->info("Updating depreciation for {$items->count()} items...");

        $progressBar = $this->output->createProgressBar($items->count());
        $progressBar->start();

        $updated = 0;
        foreach ($items as $item) {
            try {
                $oldBookValue = $item->current_book_value;
                $item->updateDepreciation();
                
                if ($oldBookValue !== $item->current_book_value) {
                    $updated++;
                }
                
                $progressBar->advance();
            } catch (\Exception $e) {
                $this->error("Error updating item {$item->id}: " . $e->getMessage());
            }
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("Depreciation update completed. {$updated} items updated.");
    }
}