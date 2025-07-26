<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave_request;
use App\Models\Employee;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = Leave_request::all();
        return view ('leave-requests.index',compact('leaveRequests'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('leave-requests.create', compact('employees'));
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Leave_request::create($validated);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request created successfully.');
    }

    public function show (Leave_request $leaveRequest)
    {
        return view('leave-requests.show', compact('leaveRequest'));
    }

    public function edit(Leave_request $leaveRequest)
    {
        $employees = Employee::all();
        return view('leave-requests.edit', compact('leaveRequest', 'employees' ));
    }

    public function update(Request $request, Leave_request $leaveRequest)
    {
        $validated = $request->validate([
            'employee_id' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $leaveRequest->update($validated);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request updated successfully');
    }

    public function destroy(Leave_request $leaveRequest)
    {
        $leaveRequest->delete();
        return redirect()->route('leave-requests.index')->with('success', 'Leave request deleted successfully');
    }
}
