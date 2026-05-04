<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'item_id',
        'quantity',
        'unit_cost',
        'purchase_price',
        'purchase_date',
        'depreciation_method',
        'useful_life_years',
        'salvage_value',
        'depreciation_rate',
        'manufacture_date',
        'expiry_date',
        'supplier',
        'lot_number',
        'notes',
        'status'
    ];

    protected $casts = [
        'manufacture_date' => 'date',
        'expiry_date' => 'date',
        'purchase_date' => 'date',
        'unit_cost' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'salvage_value' => 'decimal:2',
        'depreciation_rate' => 'decimal:2',
    ];

    /**
     * Get the item that owns this batch
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get items in this batch
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Check if batch is expired
     */
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if batch is expiring soon (within 30 days)
     */
    public function isExpiringSoon($days = 30)
    {
        return $this->expiry_date && !$this->isExpired() && $this->expiry_date->lte(now()->addDays($days));
    }

    /**
     * Get remaining shelf life in days
     */
    public function getRemainingShelfLife()
    {
        if (!$this->expiry_date) {
            return null;
        }

        return $this->expiry_date->diffInDays(now(), false);
    }

    /**
     * Generate unique batch number
     */
    public static function generateBatchNumber()
    {
        do {
            $batchNumber = 'B' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        } while (self::where('batch_number', $batchNumber)->exists());

        return $batchNumber;
    }

    /**
     * Scope for active batches
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for expired batches
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now())->orWhere('status', 'expired');
    }

    /**
     * Scope for expiring soon
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_date', '>', now())
                    ->where('expiry_date', '<=', now()->addDays($days))
                    ->where('status', 'active');
    }

    /**
     * Check if this batch has depreciation configured
     */
    public function hasDepreciation(): bool
    {
        return $this->depreciation_method && $this->depreciation_method !== 'none'
            && $this->purchase_price && $this->purchase_date && $this->useful_life_years;
    }

    /**
     * Calculate accumulated depreciation for this batch
     */
    public function calculateDepreciation(): float
    {
        if (!$this->hasDepreciation()) return 0;

        $yearsElapsed = $this->purchase_date->diffInYears(now());

        if ($yearsElapsed >= $this->useful_life_years) {
            return $this->purchase_price - ($this->salvage_value ?? 0);
        }

        return match($this->depreciation_method) {
            'straight_line'    => $this->straightLineDepreciation($yearsElapsed),
            'declining_balance' => $this->decliningBalanceDepreciation($yearsElapsed),
            default            => 0,
        };
    }

    private function straightLineDepreciation(float $yearsElapsed): float
    {
        $depreciable = $this->purchase_price - ($this->salvage_value ?? 0);
        return ($depreciable / $this->useful_life_years) * $yearsElapsed;
    }

    private function decliningBalanceDepreciation(float $yearsElapsed): float
    {
        $rate = 2 / $this->useful_life_years;
        $bookValue = $this->purchase_price;
        $total = 0;

        for ($year = 1; $year <= $yearsElapsed; $year++) {
            $yearly = $bookValue * $rate;
            $remaining = $this->purchase_price - ($this->salvage_value ?? 0) - $total;
            if ($yearly > $remaining) $yearly = $remaining;
            $total += $yearly;
            $bookValue -= $yearly;
            if ($total >= $this->purchase_price - ($this->salvage_value ?? 0)) break;
        }

        return $total;
    }

    /**
     * Get current book value for this batch
     */
    public function getCurrentBookValue(): ?float
    {
        if (!$this->purchase_price) return null;
        return max($this->purchase_price - $this->calculateDepreciation(), $this->salvage_value ?? 0);
    }

    /**
     * Mark batch as expired and deduct quantity from item (for consumables only)
     */
    public function markAsExpired()
    {
        if ($this->status === 'expired') {
            return false;
        }

        $item = $this->item;

        $this->update(['status' => 'expired']);

        if ($item && $item->item_type === 'consumable') {
            $item->decrement('quantity', $this->quantity);

            // Log a spoiled transaction for audit trail
            \App\Models\Transaction::create([
                'item_id'          => $item->id,
                'user_id'          => 1, // system action — use first admin
                'type'             => 'out',
                'transaction_type' => 'spoiled',
                'quantity'         => $this->quantity,
                'notes'            => 'Batch ' . $this->batch_number . ' expired — stock deducted automatically.',
                'reference_number' => 'SPL-' . str_pad(\App\Models\Transaction::where('transaction_type', 'spoiled')->count() + 1, 3, '0', STR_PAD_LEFT),
                'transaction_date' => now(),
            ]);

            if ($item->quantity <= 0) {
                $item->update(['status' => 'spoiled', 'quantity' => 0]);
            }

            return true;
        }

        return false;
    }
}