<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::orderBy('name');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->appends($request->query());
        $departments = \App\Models\Department::where('is_active', true)->orderBy('name')->get();
        return view('users.index', compact('users', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check for duplicate email first
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->route('users.index')
                ->with('warning', 'A user with email "' . $request->email . '" already exists. Please use a different email address.');
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,staff',
                'department' => 'required|string|max:255',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'department' => $validated['department'],
                'is_active' => true,
            ]);

            // Send welcome email with credentials
            try {
                \Mail::to($user->email)->send(new \App\Mail\WelcomeUser($user, $validated['password']));
            } catch (\Exception $e) {
                \Log::error('Failed to send welcome email to ' . $user->email . ': ' . $e->getMessage());
            }

            return redirect()->route('users.index')
                ->with('success', 'User "' . $user->name . '" created successfully with email: ' . $user->email);
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('users.index')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check the form and try again.');
                
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Check for duplicate email (excluding current user)
        $existingUser = User::where('email', $request->email)
            ->where('id', '!=', $user->id)
            ->first();
        if ($existingUser) {
            return redirect()->route('users.index')
                ->with('warning', 'A user with email "' . $request->email . '" already exists. Please use a different email address.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required|in:admin,staff',
            'department' => 'required|string|max:255',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'department' => $request->department,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'User "' . $user->name . '" updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting the current user
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('warning', 'You cannot delete your own account. Please ask another administrator to delete your account if needed.');
        }

        $userName = $user->name;
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User "' . $userName . '" deleted successfully.');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('warning', 'You cannot deactivate your own account.');
        }
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('users.index')
            ->with('success', 'User "' . $user->name . '" has been ' . $status . '.');
    }
}
