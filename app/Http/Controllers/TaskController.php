<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index()
    {
        if (session('role') === 'HR') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('assigned_to', session('employee_id'))->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:employees,id',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        Gate::authorize('access-employee-record', [$task->assigned_to]);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = Employee::all();

        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:employees,id',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }

    public function markAsDone(int $id)
    {
        $task = Task::findOrFail($id);
        Gate::authorize('access-employee-record', [$task->assigned_to]);
        $task->update(['status' => 'done']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as done successfully');
    }

    public function markAsPending(int $id)
    {
        $task = Task::findOrFail($id);
        Gate::authorize('access-employee-record', [$task->assigned_to]);
        $task->update(['status' => 'pending']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as pending successfully');
    }
}
