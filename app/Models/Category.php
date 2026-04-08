<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'level',
        'path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the items for the category.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors (parent, grandparent, etc.)
     */
    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }

    /**
     * Get the subcategories for the category (for backward compatibility).
     */
    public function subcategories()
    {
        return $this->children();
    }

    /**
     * Check if this category is a root category (has no parent)
     */
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if this category is a leaf category (has no children)
     */
    public function isLeaf()
    {
        return $this->children()->count() === 0;
    }

    /**
     * Get the full path of the category
     */
    public function getFullPath()
    {
        if ($this->path) {
            return $this->path;
        }

        $path = [];
        $category = $this;
        
        while ($category) {
            array_unshift($path, $category->name);
            $category = $category->parent_id ? Category::find($category->parent_id) : null;
        }
        
        return implode(' > ', $path);
    }

    /**
     * Update the path for this category and all its descendants
     */
    public function updatePath()
    {
        $this->path = $this->getFullPath();
        $this->save();

        // Update all descendants
        foreach ($this->children as $child) {
            $child->updatePath();
        }
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            // Calculate level based on parent
            if ($category->parent_id) {
                $parent = Category::find($category->parent_id);
                $category->level = $parent ? $parent->level + 1 : 0;
            } else {
                $category->level = 0;
            }
        });

        static::saved(function ($category) {
            // Update path after saving
            $category->path = $category->getFullPath();
            $category->saveQuietly(); // Use saveQuietly to avoid infinite loop
            
            // Update paths for all descendants when a category is saved
            foreach ($category->children as $child) {
                $child->updatePath();
            }
        });
    }
}
