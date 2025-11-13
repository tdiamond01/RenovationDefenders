<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('CREATED_AT', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'EMAIL' => 'required|email|unique:USERS,EMAIL',
            'PASSWORD' => 'required|string|min:8|confirmed',
            'ROLE' => ['required', Rule::in(['admin', 'user'])],
        ]);

        $validated['PASSWORD'] = Hash::make($validated['PASSWORD']);
        $validated['EMAIL_VERIFIED_AT'] = now();

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'NAME' => 'required|string|max:255',
            'EMAIL' => ['required', 'email', Rule::unique('USERS', 'EMAIL')->ignore($user->ID, 'ID')],
            'ROLE' => ['required', Rule::in(['admin', 'user'])],
            'PASSWORD' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['PASSWORD'])) {
            $validated['PASSWORD'] = Hash::make($validated['PASSWORD']);
        } else {
            unset($validated['PASSWORD']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
