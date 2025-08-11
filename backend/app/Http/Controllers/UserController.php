<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->get(); // includes soft deleted users
        return view('admin.users.index', compact('users'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'username' => 'nullable|string|unique:users,username',
            'password' => 'required|string|confirmed|min:6',
            'profile_photo' => 'nullable|image',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:6',
            'profile_photo' => 'nullable|image',
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        }

        if (!empty($request->password)) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function toggleStatus(Request $request)
    {
        $user = user::find($request->id);

        if ($user) {
            $user->status = $request->status;
            $user->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // This will soft delete the user (sets deleted_at)

        return redirect()->back()->with('success', 'User soft deleted successfully.');
    }
}
