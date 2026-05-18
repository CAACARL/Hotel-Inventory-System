<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->withCount('items')->with(['children' => function($sq) {
                    $sq->withCount('items');
                }]);
            }])
            ->withCount('items');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10)->appends($request->query());

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Get all categories for parent selection
        $parentCategories = Category::whereNull('parent_id')->with('children')->get();
        return view('categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        // Check for duplicate category name within the same parent
        $query = Category::where('name', $request->name);
        if ($request->parent_id) {
            $query->where('parent_id', $request->parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        
        $existingCategory = $query->first();
        if ($existingCategory) {
            $parentName = $request->parent_id ? Category::find($request->parent_id)->name : 'root level';
            $message = 'Category "' . $request->name . '" already exists in ' . $parentName . '. Please choose a different name.';
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            
            return redirect()->route('categories.index')
                ->with('warning', $message);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean'
        ]);

        $category = Category::create($request->all());

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'parent_id' => $category->parent_id,
                    'level' => $category->level
                ]
            ]);
        }

        $parentName = $category->parent ? $category->parent->name : 'root level';
        return redirect()->route('categories.index')
            ->with('success', 'Category "' . $request->name . '" created successfully under ' . $parentName . '.');
    }

    public function show(Category $category)
    {
        $category->load(['items' => function($query) {
            $query->paginate(10);
        }, 'children.items']);
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        // Get all categories except the current one and its descendants for parent selection
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->with(['children' => function($query) use ($category) {
                $query->where('id', '!=', $category->id);
            }])
            ->get();
            
        return view('categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        // Check for duplicate category name within the same parent (excluding current category)
        $query = Category::where('name', $request->name)->where('id', '!=', $category->id);
        if ($request->parent_id) {
            $query->where('parent_id', $request->parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        
        $existingCategory = $query->first();
        if ($existingCategory) {
            $parentName = $request->parent_id ? Category::find($request->parent_id)->name : 'root level';
            return redirect()->route('categories.index')
                ->with('warning', 'Category "' . $request->name . '" already exists in ' . $parentName . '. Please choose a different name.');
        }

        // Prevent setting parent to self or descendant
        if ($request->parent_id) {
            $descendants = $this->getDescendantIds($category);
            if ($request->parent_id == $category->id || in_array($request->parent_id, $descendants)) {
                return redirect()->route('categories.index')
                    ->with('error', 'Cannot set parent to self or descendant category.');
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean'
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category "' . $request->name . '" updated successfully.');
    }

    public function destroy(Category $category)
    {
        $totalItems = $this->countItemsRecursively($category);
        if ($totalItems > 0) {
            return redirect()->route('categories.index')
                ->with('warning', 'Cannot archive "' . $category->name . '" — it has ' . $totalItems . ' items. Remove or reassign them first.');
        }

        if ($category->children()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('warning', 'Cannot archive "' . $category->name . '" — it has subcategories. Archive or remove them first.');
        }

        $categoryName = $category->name;
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category "' . $categoryName . '" has been archived.');
    }

    public function archived()
    {
        $categories = Category::onlyTrashed()->latest('deleted_at')->paginate(15);
        return view('categories.archived', compact('categories'));
    }

    public function unarchive(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('categories.archived')
            ->with('success', 'Category "' . $category->name . '" has been restored.');
    }

    /**
     * Store a new subcategory (for backward compatibility)
     */
    public function storeSubcategory(Request $request, Category $category)
    {
        return $this->store($request->merge(['parent_id' => $category->id]));
    }

    /**
     * Update a subcategory (for backward compatibility)
     */
    public function updateSubcategory(Request $request, Subcategory $subcategory)
    {
        // This method is kept for backward compatibility but subcategories are now just categories
        $category = Category::find($subcategory->id);
        return $this->update($request, $category);
    }

    /**
     * Delete a subcategory (for backward compatibility)
     */
    public function destroySubcategory(Subcategory $subcategory)
    {
        // This method is kept for backward compatibility but subcategories are now just categories
        $category = Category::find($subcategory->id);
        return $this->destroy($category);
    }

    /**
     * Get subcategories for a category (AJAX)
     */
    public function getSubcategories(Category $category)
    {
        $subcategories = $category->children()->where('is_active', true)->get();
        return response()->json($subcategories);
    }

    /**
     * Get all categories in a hierarchical structure (AJAX)
     */
    public function getCategoriesHierarchy()
    {
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function($query) {
                $this->loadChildrenRecursively($query);
            }])
            ->where('is_active', true)
            ->get();
            
        return response()->json($categories);
    }

    /**
     * Helper method to recursively load children
     */
    private function loadChildrenRecursively($query)
    {
        $query->where('is_active', true)->with(['children' => function($subQuery) {
            $this->loadChildrenRecursively($subQuery);
        }]);
    }

    /**
     * Helper method to get all descendant IDs
     */
    private function getDescendantIds(Category $category)
    {
        $descendants = [];
        foreach ($category->children as $child) {
            $descendants[] = $child->id;
            $descendants = array_merge($descendants, $this->getDescendantIds($child));
        }
        return $descendants;
    }

    /**
     * Helper method to count items recursively
     */
    private function countItemsRecursively(Category $category)
    {
        $count = $category->items()->count();
        foreach ($category->children as $child) {
            $count += $this->countItemsRecursively($child);
        }
        return $count;
    }
}
