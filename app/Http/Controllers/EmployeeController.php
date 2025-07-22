<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Department;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view ('employees.index',compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.create', compact('departments', 'roles'));
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'status' => 'required|in:inactive,active',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:1',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
            'profile_picture' => 'nullable|image|max:2048', // Optional image upload
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show (Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.edit', compact('employee','departments', 'roles'));
    }

    public function update(Request $request, Employee $employee)
    {
       $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'status' => 'required|in:inactive,active',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:1',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
            'profile_picture' => 'nullable|image|max:2048', // Optional image upload
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}
