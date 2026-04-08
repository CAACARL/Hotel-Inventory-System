<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::withCount('items')->orderBy('name')->paginate(15);
        return view('departments.index', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check for duplicate department name first
        $existingDepartment = Department::where('name', $request->name)->first();
        if ($existingDepartment) {
            return redirect()->route('departments.index')
                ->with('warning', 'Department "' . $request->name . '" already exists. Please choose a different name.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
            ->with('success', 'Department "' . $request->name . '" created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load(['items.category']);
        return view('departments.show', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        // Check for duplicate department name (excluding current department)
        $existingDepartment = Department::where('name', $request->name)
            ->where('id', '!=', $department->id)
            ->first();
        if ($existingDepartment) {
            return redirect()->route('departments.index')
                ->with('warning', 'Department "' . $request->name . '" already exists. Please choose a different name.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $updateData = $request->all();
        $updateData['is_active'] = $request->has('is_active');

        $department->update($updateData);

        return redirect()->route('departments.index')
            ->with('success', 'Department "' . $request->name . '" updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // Check if department has items
        if ($department->items()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('warning', 'Cannot delete department "' . $department->name . '" because it has ' . $department->items()->count() . ' items. Please reassign the items to another department first.');
        }

        $departmentName = $department->name;
        $department->delete();
        return redirect()->route('departments.index')
            ->with('success', 'Department "' . $departmentName . '" deleted successfully.');
    }
}