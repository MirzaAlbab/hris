<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view ('tasks.index',compact('tasks'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('tasks.create', compact('employees'));
    }

    public function store (Request $request)
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

    public function show (Task $task)
    {
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
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found');
        }
        $task->update(['status' => 'done']);
        return redirect()->route('tasks.index')->with('success', 'Task marked as done successfully');
    }
    public function markAsPending(int $id)
    {
         $task = Task::findOrFail($id);
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found');
        }
        $task->update(['status' => 'pending']);
        return redirect()->route('tasks.index')->with('success', 'Task marked as pending successfully');
    }
}
