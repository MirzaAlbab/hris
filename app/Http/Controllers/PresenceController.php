<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Presence;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::all();
        return view ('presences.index',compact('presences'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('presences.create', compact('employees'));
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required',
            'date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|string|in:present,absent,late,leave'
        ]);

        Presence::create($validated);

        return redirect()->route('presences.index')->with('success', 'Presence recorded successfully.');
    }

    public function show (Presence $presence)
    {
        return view('presences.show', compact('presence'));
    }

    public function edit(Presence $presence)
    {
        $employees = Employee::all();
        return view('presences.edit', compact('presence', 'employees' ));
    }

    public function update(Request $request, Presence $presence)
    {
        $validated = $request->validate([
            'employee_id' => 'required',
            'date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|string|in:present,absent,late,leave'
        ]);

        $presence->update($validated);

        return redirect()->route('presences.index')->with('success', 'Presence updated successfully');
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();
        return redirect()->route('presences.index')->with('success', 'Presence deleted successfully');
    }
}
