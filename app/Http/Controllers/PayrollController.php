<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PayrollController extends Controller
{
    public function index()
    {
        if (session('role') == 'HR') {
            $payrolls = Payroll::all();
        } else {
            $payrolls = Payroll::where('employee_id', session('employee_id'))->get();
        }

        return view('payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::all();

        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'allowances' => 'required|numeric',
            'deductions' => 'required|numeric',
            'pay_date' => 'required|date',
        ]);
        $netSalary = $validated['salary'] + $validated['allowances'] - $validated['deductions'];
        $validated['net_salary'] = $netSalary;

        Payroll::create($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll recorded successfully.');
    }

    public function show(Payroll $payroll)
    {
        Gate::authorize('access-employee-record', [$payroll->employee_id]);

        return view('payrolls.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        $employees = Employee::all();

        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'allowances' => 'required|numeric',
            'deductions' => 'required|numeric',
            'pay_date' => 'required|date',
        ]);
        $netSalary = $validated['salary'] + $validated['allowances'] - $validated['deductions'];
        $validated['net_salary'] = $netSalary;

        $payroll->update($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll updated successfully');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted successfully');
    }
}
