<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class UpdateCategoryHierarchy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:update-hierarchy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update category levels and paths for proper hierarchy display';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating category hierarchy...');
        
        // Get all categories
        $categories = Category::all();
        
        // First, update levels for all categories
        foreach ($categories as $category) {
            $level = 0;
            $parent = $category->parent_id ? $categories->find($category->parent_id) : null;
            
            while ($parent) {
                $level++;
                $parent = $parent->parent_id ? $categories->find($parent->parent_id) : null;
            }
            
            $category->level = $level;
            $category->saveQuietly();
        }
        
        // Then, update paths for all categories
        foreach ($categories as $category) {
            $path = [];
            $current = $category;
            
            while ($current) {
                array_unshift($path, $current->name);
                $current = $current->parent_id ? $categories->find($current->parent_id) : null;
            }
            
            $category->path = implode(' > ', $path);
            $category->saveQuietly();
        }
        
        $this->info('Category hierarchy updated successfully!');
        
        // Display the hierarchy
        $this->info('Current hierarchy:');
        foreach ($categories->sortBy('path') as $category) {
            $indent = str_repeat('  ', $category->level);
            $this->line($indent . $category->name . ' (Level: ' . $category->level . ', Path: ' . $category->path . ')');
        }
        
        return 0;
    }
}