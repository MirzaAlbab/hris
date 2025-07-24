<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view ('roles.index',compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'role created successfully.');
    }

    public function show (Role $role)
    {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role' ));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'role deleted successfully');
    }
}
