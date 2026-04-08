<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
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
        'purchase_price',
        'purchase_date',
        'useful_life_years',
        'depreciation_method',
        'depreciation_rate',
        'salvage_value',
        'current_book_value',
        'accumulated_depreciation',
        'last_depreciation_date',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'purchase_price' => 'decimal:2',
            'purchase_date' => 'date',
            'salvage_value' => 'decimal:2',
            'depreciation_rate' => 'decimal:2',
            'current_book_value' => 'decimal:2',
            'accumulated_depreciation' => 'decimal:2',
            'last_depreciation_date' => 'date',
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
     * Calculate current depreciation based on method
     */
    public function calculateDepreciation()
    {
        if (!$this->purchase_price || !$this->purchase_date || !$this->useful_life_years || $this->depreciation_method === 'none') {
            return 0;
        }

        $yearsElapsed = $this->purchase_date->diffInYears(now());
        
        if ($yearsElapsed >= $this->useful_life_years) {
            return $this->purchase_price - ($this->salvage_value ?? 0);
        }

        switch ($this->depreciation_method) {
            case 'straight_line':
                return $this->calculateStraightLineDepreciation($yearsElapsed);
            case 'declining_balance':
                return $this->calculateDecliningBalanceDepreciation($yearsElapsed);
            default:
                return 0;
        }
    }

    /**
     * Calculate straight-line depreciation
     */
    private function calculateStraightLineDepreciation($yearsElapsed)
    {
        $depreciableAmount = $this->purchase_price - ($this->salvage_value ?? 0);
        $annualDepreciation = $depreciableAmount / $this->useful_life_years;
        
        return $annualDepreciation * $yearsElapsed;
    }

    /**
     * Calculate declining balance depreciation (double declining)
     */
    private function calculateDecliningBalanceDepreciation($yearsElapsed)
    {
        $rate = 2 / $this->useful_life_years; // Double declining rate
        $bookValue = $this->purchase_price;
        $totalDepreciation = 0;

        for ($year = 1; $year <= $yearsElapsed; $year++) {
            $yearlyDepreciation = $bookValue * $rate;
            $remainingDepreciable = $this->purchase_price - ($this->salvage_value ?? 0) - $totalDepreciation;
            
            if ($yearlyDepreciation > $remainingDepreciable) {
                $yearlyDepreciation = $remainingDepreciable;
            }
            
            $totalDepreciation += $yearlyDepreciation;
            $bookValue -= $yearlyDepreciation;
            
            if ($totalDepreciation >= $this->purchase_price - ($this->salvage_value ?? 0)) {
                break;
            }
        }

        return $totalDepreciation;
    }

    /**
     * Get current book value
     */
    public function getCurrentBookValue()
    {
        if (!$this->purchase_price) {
            return null;
        }

        $depreciation = $this->calculateDepreciation();
        return max($this->purchase_price - $depreciation, $this->salvage_value ?? 0);
    }

    /**
     * Alias for getCurrentBookValue() for consistency
     */
    public function getCurrentValue()
    {
        return $this->getCurrentBookValue();
    }

    /**
     * Update depreciation values
     */
    public function updateDepreciation()
    {
        $this->accumulated_depreciation = $this->calculateDepreciation();
        $this->current_book_value = $this->getCurrentBookValue();
        $this->last_depreciation_date = now();
        $this->save();
    }

    /**
     * Check if item needs depreciation update
     */
    public function needsDepreciationUpdate()
    {
        if ($this->depreciation_method === 'none' || !$this->purchase_date) {
            return false;
        }

        return !$this->last_depreciation_date || 
               $this->last_depreciation_date->diffInMonths(now()) >= 1;
    }

    /**
     * Scope for items needing depreciation update
     */
    public function scopeNeedsDepreciationUpdate($query)
    {
        return $query->where('depreciation_method', '!=', 'none')
                    ->whereNotNull('purchase_date')
                    ->where(function ($q) {
                        $q->whereNull('last_depreciation_date')
                          ->orWhere('last_depreciation_date', '<', now()->subMonth());
                    });
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
