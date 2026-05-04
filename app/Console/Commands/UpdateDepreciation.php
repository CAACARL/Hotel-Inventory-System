<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Batch;

class UpdateDepreciation extends Command
{
    protected $signature = 'depreciation:update {--force : Force update all batches}';
    protected $description = 'Recalculate depreciation book values for all active batches';

    public function handle()
    {
        $this->info('Starting depreciation update...');

        $query = Batch::where('status', 'active')
            ->where('depreciation_method', '!=', 'none')
            ->whereNotNull('purchase_date')
            ->whereNotNull('purchase_price');

        $batches = $query->get();

        if ($batches->isEmpty()) {
            $this->info('No batches need depreciation updates.');
            return;
        }

        $this->info("Updating depreciation for {$batches->count()} batches...");

        $bar = $this->output->createProgressBar($batches->count());
        $bar->start();

        foreach ($batches as $batch) {
            // Depreciation is calculated on-the-fly via Batch::calculateDepreciation()
            // Nothing to persist — just confirm the batch is valid
            $batch->getCurrentBookValue();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Done. {$batches->count()} batches processed.");
    }
}
