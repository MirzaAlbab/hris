<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $department = Department::count();
        $employee = Employee::count();
        $presence = Presence::count();
        $payroll = Payroll::count();
        $tasks = Task::with('employee')
            ->when(session('role') !== 'HR', fn ($query) => $query->where('assigned_to', session('employee_id')))
            ->get();

        return view('dashboard.index', compact('department', 'employee', 'presence', 'payroll', 'tasks'));
    }

    public function presence()
    {
        $month = DB::connection()->getDriverName() === 'sqlite'
            ? "CAST(strftime('%m', date) AS INTEGER)"
            : 'MONTH(date)';

        $counts = Presence::where('status', 'present')
            ->whereYear('date', now()->year)
            ->when(session('role') !== 'HR', fn ($query) => $query->where('employee_id', session('employee_id')))
            ->selectRaw("{$month} as month, COUNT(*) as total_present")
            ->groupBy('month')
            ->pluck('total_present', 'month');

        return response()->json(collect(range(1, 12))
            ->map(fn ($month) => (int) $counts->get($month, 0)));
    }
}
