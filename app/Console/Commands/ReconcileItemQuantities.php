<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use App\Models\Batch;

class ReconcileItemQuantities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:reconcile-quantities {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reconcile item quantities with batch totals to fix any discrepancies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        $this->info('Starting inventory reconciliation...');
        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }
        $this->newLine();

        $items = Item::withTrashed()->with('batches')->get();
        $totalItems = $items->count();
        $mismatches = 0;
        $fixed = 0;
        $legacyBatchesCreated = 0;

        $this->withProgressBar($items, function ($item) use (&$mismatches, &$fixed, &$legacyBatchesCreated, $isDryRun) {
            // Calculate actual batch total
            $batchTotal = $item->batches()->sum('quantity');
            
            // Check for mismatch
            if ($item->quantity != $batchTotal) {
                $mismatches++;
                
                // Case 1: No batches but item has quantity (legacy data)
                if ($batchTotal == 0 && $item->quantity > 0 && !$item->batches()->exists()) {
                    $this->newLine();
                    $this->warn("  Item #{$item->id} '{$item->name}': No batches found, has {$item->quantity} units");
                    
                    if (!$isDryRun) {
                        // Create legacy batch for historical stock
                        Batch::create([
                            'item_id' => $item->id,
                            'batch_number' => 'LEGACY-' . str_pad($item->id, 6, '0', STR_PAD_LEFT),
                            'quantity' => $item->quantity,
                            'status' => 'active',
                            'supplier' => 'System (Legacy Data)',
                            'location' => 'Unknown (Legacy)',
                            'notes' => 'Automatically created batch for pre-existing inventory',
                            'purchase_date' => now()->toDateString(),
                        ]);
                        $legacyBatchesCreated++;
                        $this->info("  → Created legacy batch with {$item->quantity} units");
                    } else {
                        $this->comment("  → Would create legacy batch with {$item->quantity} units");
                    }
                }
                // Case 2: Batches exist, trust them
                elseif ($batchTotal >= 0) {
                    $this->newLine();
                    $this->warn("  Item #{$item->id} '{$item->name}': Mismatch detected");
                    $this->line("    Item quantity: {$item->quantity}");
                    $this->line("    Batch total: {$batchTotal}");
                    $this->line("    Difference: " . ($item->quantity - $batchTotal));
                    
                    if (!$isDryRun) {
                        $item->update(['quantity' => $batchTotal]);
                        $fixed++;
                        $this->info("  → Fixed: Set item quantity to {$batchTotal}");
                    } else {
                        $this->comment("  → Would fix: Set item quantity to {$batchTotal}");
                    }
                }
            }
        });

        $this->newLine(2);
        $this->info('Reconciliation complete!');
        $this->newLine();
        
        // Summary table
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total items checked', $totalItems],
                ['Mismatches found', $mismatches],
                ['Items fixed', $fixed],
                ['Legacy batches created', $legacyBatchesCreated],
                ['Items in sync', $totalItems - $mismatches],
            ]
        );

        if ($isDryRun && $mismatches > 0) {
            $this->newLine();
            $this->warn('This was a dry run. Run without --dry-run to apply fixes.');
        }

        if (!$isDryRun && ($fixed > 0 || $legacyBatchesCreated > 0)) {
            $this->newLine();
            $this->info('✓ All discrepancies have been resolved.');
        }

        if ($mismatches == 0) {
            $this->newLine();
            $this->info('✓ All items are already in sync. No issues found.');
        }

        return Command::SUCCESS;
    }
}
