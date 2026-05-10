<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */    
    public function index()
    {
        // Get all users (lecturers and students)
        $users = User::where('role', '!=', 'admin')
            ->latest()
            ->get();

        // Displa
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Display create user form
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'identity_number' => 'nullable|string',
            'phone_number' => 'sometimes|regex:/^[0-9]+$/|min:9|max:13',
            'identity_number' =>'sometimes|string|max:16|unique:users',
            'role' => 'required|in:student,lecturer',
            'password' => 'required|min:6',
        ]);

        // Add user data into database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'identity_number' => $request->identity_number,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Display admin dashboard
        return redirect()->route('admin.dashboard')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(string $id)
    {
        // Get designated user
        $user = User::findOrFail($id);

        // Display edit user form
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get designated user
        $user = User::findOrFail($id);

        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'sometimes|regex:/^[0-9]+$/|min:9|max:13',
            'identity_number' =>'sometimes|string|max:16',
            'role' => 'required|in:student,lecturer',
        ]);

        // Update user data into database
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'identity_number' => $request->identity_number,
            'role' => $request->role,
        ]);

        // Display admin dashboard
        return redirect()->route('admin.dashboard')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        // Get designated user
        $user = User::findOrFail($id);

        // Prevent deleting admins accidentally
        if ($user->role === 'admin') {
            return back()->withErrors('Cannot delete admin user.');
        }

        // Delete user data from database
        $user->delete();

        // Display previous page
        return back()->with('success', 'User deleted successfully.');
    }
}
