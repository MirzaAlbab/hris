<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeaveRequestController extends Controller
{
    public function index()
    {
        if (session('role') == 'HR') {
            $leaveRequests = Leave_request::all();
        } else {
            $leaveRequests = Leave_request::where('employee_id', session('employee_id'))->get();
        }

        return view('leave-requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('leave-requests.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:sick,vacation,birth',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if (session('role') == 'HR') {
            $validated += $request->validate([
                'employee_id' => 'required|exists:employees,id',
            ]);
        } else {
            $validated['employee_id'] = session('employee_id');
        }

        Leave_request::create($validated);

        return redirect()->route('leave-requests.index')->with('success', 'Leave request created successfully.');
    }

    public function show(Leave_request $leaveRequest)
    {
        Gate::authorize('access-employee-record', [$leaveRequest->employee_id]);

        return view('leave-requests.show', compact('leaveRequest'));
    }

    public function edit(Leave_request $leaveRequest)
    {
        $employees = Employee::all();

        return view('leave-requests.edit', compact('leaveRequest', 'employees'));
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

    public function confirm($id)
    {
        $leaveRequest = Leave_request::findOrFail($id);
        $leaveRequest->status = 'confirm';
        $leaveRequest->save();

        return redirect()->route('leave-requests.index')->with('success', 'Leave request confirmed successfully');
    }

    public function reject($id)
    {
        $leaveRequest = Leave_request::findOrFail($id);
        $leaveRequest->status = 'reject';
        $leaveRequest->save();

        return redirect()->route('leave-requests.index')->with('success', 'Leave request rejected successfully');
    }
}
