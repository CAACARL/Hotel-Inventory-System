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
        'unit_cost' => 'decimal:2'
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
     * Mark batch as expired and deduct quantity from item (for consumables only)
     */
    public function markAsExpired()
    {
        if ($this->status === 'expired') {
            return false; // Already expired
        }

        $item = $this->item;

        // Mark batch as expired
        $this->update(['status' => 'expired']);

        // Only deduct quantity for consumable items
        if ($item && $item->item_type === 'consumable') {
            // Deduct the batch quantity from the item's total quantity
            $item->decrement('quantity', $this->quantity);

            // Mark item as spoiled if quantity reaches 0 or below
            if ($item->quantity <= 0) {
                $item->update(['status' => 'spoiled', 'quantity' => 0]);
            }

            return true;
        }

        return false;
    }
}