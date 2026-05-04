<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Item extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'department_id',
        'batch_id',
        'quantity',
        'minimum_stock',
        'unit',
        'status',
        'item_type',
        'location',
        'unit_price',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
        ];
    }

    /**
     * Get the category that owns the item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the full category path for this item
     */
    public function getCategoryPath()
    {
        return $this->category ? $this->category->getFullPath() : null;
    }

    /**
     * Get the department that owns the item.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the batch that owns the item.
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get the transactions for the item.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the borrowed items for the item.
     */
    public function borrowedItems()
    {
        return $this->hasMany(BorrowedItem::class);
    }

    /**
     * Check if item is low stock.
     */
    public function isLowStock()
    {
        return $this->quantity <= $this->minimum_stock;
    }

    /**
     * Scope for low stock items.
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= minimum_stock');
    }

    /**
     * Get the quantity of items currently borrowed (not yet returned).
     */
    public function getBorrowedQuantityAttribute()
    {
        return $this->borrowedItems()->sum('quantity');
    }

    /**
     * Get the quantity of items currently borrowed by a specific user (not yet returned).
     */
    public function getBorrowedQuantityByUser($userId)
    {
        $borrowedItem = $this->borrowedItems()->where('user_id', $userId)->first();
        return $borrowedItem ? $borrowedItem->quantity : 0;
    }

    /**
     * Get current book value from the item's batch (if any)
     */
    public function getCurrentValue(): ?float
    {
        return $this->batch?->getCurrentBookValue();
    }

    /**
     * Check if item is from an expired batch
     */
    public function isFromExpiredBatch()
    {
        return $this->batch && $this->batch->isExpired();
    }

    /**
     * Check if item is from a batch expiring soon
     */
    public function isFromExpiringSoonBatch($days = 30)
    {
        return $this->batch && $this->batch->isExpiringSoon($days);
    }

    /**
     * Check if item is consumable
     */
    public function isConsumable()
    {
        return $this->item_type === 'consumable';
    }

    /**
     * Check if item is non-consumable
     */
    public function isNonConsumable()
    {
        return $this->item_type === 'non-consumable';
    }

    /**
     * Check if item is spoiled
     */
    public function isSpoiled()
    {
        return $this->status === 'spoiled';
    }

    /**
     * Check and mark item as spoiled if it's consumable and from expired batch
     */
    public function checkAndMarkSpoiled()
    {
        if ($this->isConsumable() && $this->isFromExpiredBatch() && !$this->isSpoiled()) {
            $this->status = 'spoiled';
            $this->save();
            return true;
        }
        return false;
    }
}
