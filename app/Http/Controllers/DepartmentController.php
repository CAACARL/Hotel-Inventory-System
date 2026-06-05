<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Department::withCount('items')->orderBy('name');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $departments = $query->paginate(15)->appends($request->query());
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
            return redirect()->route('departments.index', ['page' => $request->input('page', 1)])
                ->with('warning', 'Department "' . $request->name . '" already exists. Please choose a different name.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        Department::create($request->all());

        $department = Department::where('name', $request->name)->first();
        ActivityLog::log('created', $department);

        return redirect()->route('departments.index', ['page' => $request->input('page', 1)])
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
            return redirect()->route('departments.index', ['page' => $request->input('page', 1)])
                ->with('warning', 'Department "' . $request->name . '" already exists. Please choose a different name.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        $updateData = $request->only(['name', 'description', 'location']);

        $oldValues = $department->only(['name', 'description', 'location']);
        $department->update($updateData);
        
        ActivityLog::log('updated', $department, $oldValues, $updateData);

        return redirect()->route('departments.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Department "' . $request->name . '" updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function toggleActive(Request $request, Department $department)
    {
        $oldStatus = $department->is_active;
        $department->update(['is_active' => !$department->is_active]);
        $status = $department->is_active ? 'activated' : 'deactivated';
        
        ActivityLog::log($status, $department, ['is_active' => $oldStatus], ['is_active' => $department->is_active]);
        
        return redirect()->route('departments.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Department "' . $department->name . '" has been ' . $status . '.');
    }
    public function destroy(Request $request, Department $department)
    {
        if ($department->items()->count() > 0) {
            return redirect()->route('departments.index', ['page' => $request->input('page', 1)])
                ->with('warning', 'Cannot delete department "' . $department->name . '" because it has ' . $department->items()->count() . ' items. Please reassign the items to another department first.');
        }

        $departmentName = $department->name;
        $department->delete();
        return redirect()->route('departments.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Department "' . $departmentName . '" deleted successfully.');
    }
}