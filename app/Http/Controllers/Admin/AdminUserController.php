<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Ensure the Role model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Use Hash facade

class AdminUserController extends Controller
{
    // Display a list of users
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        $roles = Role::all(); // Fetch all roles to pass to the view
        return view('admin.users.create', compact('roles'));
    }

    // Store a newly created user in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Validate unique email
            'password' => 'required|string|min:8|confirmed', // Ensure password is confirmed
            'role_id' => 'required|exists:roles,id', // Ensure role exists in roles table
        ]);

        // Create the user with encrypted password
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypt password
            'role_id' => $request->role_id, // Assign the role ID
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    // Display the specified user
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        $roles = Role::all(); // Fetch all roles to pass to the view
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Update the specified user in storage
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Validate unique email except for the current user
            'password' => 'nullable|string|min:8|confirmed', // Password is optional
            'role_id' => 'required|exists:roles,id', // Ensure role exists
        ]);

        // Prepare user data for update
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password); // Encrypt new password
        }

        // Update user data
        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
