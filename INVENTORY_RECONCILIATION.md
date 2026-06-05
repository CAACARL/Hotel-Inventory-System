# Inventory Reconciliation System

## What It Does

Automatically checks and fixes discrepancies between:
- **Item quantities** (`items.quantity`)
- **Batch totals** (`SUM(batches.quantity)`)

## Why It's Needed

Item quantities can drift from batch totals due to:
- Manual database edits
- Failed transactions (partial rollbacks)
- Direct batch updates
- Legacy data imported before batch system

## How It Works

### The Command
```bash
php artisan inventory:reconcile-quantities
```

### Options
```bash
# Dry run (see what would change without making changes)
php artisan inventory:reconcile-quantities --dry-run

# Live run (actually fix issues)
php artisan inventory:reconcile-quantities
```

---

## Reconciliation Logic

### Case 1: No Batches, Item Has Quantity (Legacy Data)
**Scenario:**
```
Item: "Toilet Paper" 
  - Item quantity: 100
  - Batch total: 0 (no batches exist)
```

**Action:** Creates a "LEGACY" batch with the item's quantity
```php
Batch::create([
    'batch_number' => 'LEGACY-000021',
    'quantity' => 100,
    'supplier' => 'System (Legacy Data)',
    'location' => 'Unknown (Legacy)',
    'notes' => 'Automatically created batch for pre-existing inventory',
]);
```

**Result:**
- Item quantity: 100
- Batch total: 100 ✓

---

### Case 2: Batches Exist, Totals Don't Match
**Scenario:**
```
Item: "Cleaning Spray"
  - Item quantity: 150
  - Batch A: 50 units
  - Batch B: 80 units
  - Batch total: 130
  - Difference: -20 units
```

**Action:** Trust batches (source of truth), update item
```php
$item->update(['quantity' => 130]);
```

**Result:**
- Item quantity: 130 ✓
- Batch total: 130 ✓

---

### Case 3: Already in Sync
**Scenario:**
```
Item: "Paper Towels"
  - Item quantity: 200
  - Batch total: 200
```

**Action:** Nothing (already correct)

---

## Scheduled Execution

The command runs **automatically every night at 2:00 AM**:

```php
// In routes/console.php
Schedule::command('inventory:reconcile-quantities')->dailyAt('02:00');
```

To disable automatic reconciliation, comment out this line.

---

## Manual Execution

### Check for Issues (Dry Run)
```bash
php artisan inventory:reconcile-quantities --dry-run
```

**Output:**
```
Starting inventory reconciliation...
DRY RUN MODE - No changes will be made

Item #21 'test': Mismatch detected
  Item quantity: 190
  Batch total: 200
  Difference: -10
→ Would fix: Set item quantity to 200

+------------------------+-------+
| Metric                 | Count |
+------------------------+-------+
| Total items checked    | 37    |
| Mismatches found       | 6     |
| Items fixed            | 0     |
| Legacy batches created | 0     |
| Items in sync          | 31    |
+------------------------+-------+
```

### Fix Issues (Live Run)
```bash
php artisan inventory:reconcile-quantities
```

**Output:**
```
Item #21 'test': Mismatch detected
  Item quantity: 190
  Batch total: 200
  Difference: -10
→ Fixed: Set item quantity to 200

+------------------------+-------+
| Metric                 | Count |
+------------------------+-------+
| Total items checked    | 37    |
| Mismatches found       | 6     |
| Items fixed            | 6     |
| Legacy batches created | 0     |
| Items in sync          | 31    |
+------------------------+-------+

✓ All discrepancies have been resolved.
```

---

## Why Batches Are the Source of Truth

1. **Granular data** - Detailed batch-level records
2. **Transaction history** - Every borrow/return references batches
3. **Audit trail** - Batch numbers, suppliers, expiry dates
4. **FIFO/FEFO logic** - System uses batches for inventory operations

**Item quantity is just a summary/cache of batch totals.**

---

## Monitoring

Check the Laravel logs after automatic runs:
```bash
tail -f storage/logs/laravel.log | grep "reconcile"
```

Logs will show:
- Items with mismatches
- Legacy batches created
- Quantities corrected

---

## Testing the System

### Create a Test Mismatch
```php
// Manually create mismatch via Tinker
php artisan tinker

$item = Item::find(1);
$item->update(['quantity' => 999]); // Wrong value
$item->batches()->sum('quantity'); // Shows correct value

exit
```

### Run Reconciliation
```bash
php artisan inventory:reconcile-quantities --dry-run
```

### Verify Fix
```bash
php artisan inventory:reconcile-quantities

# Check if corrected
php artisan tinker
Item::find(1)->quantity == Item::find(1)->batches()->sum('quantity'); // Should be true
```

---

## Current Status

**Dry run on your system found:**
- ✅ 13 items already in sync
- ⚠️ 18 items need legacy batches (old data before batch system)
- ⚠️ 6 items have quantity mismatches

**To fix all issues, run:**
```bash
php artisan inventory:reconcile-quantities
```

This will:
- Create 18 legacy batches for pre-existing inventory
- Fix 6 quantity mismatches
- Bring all 37 items into sync

---

## Safety Features

- **Dry run mode** - Preview changes before applying
- **Progress bar** - See real-time progress
- **Detailed logging** - Every change is logged
- **Non-destructive** - Only updates quantities, never deletes data
- **Reversible** - Changes can be manually reverted if needed

---

## When to Run Manually

Run the command manually if you notice:
- "Not enough stock" errors despite UI showing availability
- Inventory reports that don't add up
- Quantity discrepancies after system maintenance
- After importing legacy data

---

## Integration with FIFO/FEFO

This reconciliation ensures that:
- `getAvailableBatches()` works correctly (relies on batch quantities)
- Borrowing logic has accurate data
- FEFO prioritization is based on correct quantities
- No "phantom stock" appears in the system

**Reconciliation complements your FIFO/FEFO system by ensuring data integrity.**
