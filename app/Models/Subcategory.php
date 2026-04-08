<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the subcategory
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the items for the subcategory
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Scope a query to only include active subcategories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}