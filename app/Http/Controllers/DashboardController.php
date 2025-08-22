<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $department = Department::count();
        $employee = Employee::count();
        $presence = Presence::count();
        $payroll = Payroll::count();
        $tasks = Task::all();

        return view('dashboard.index', compact('department','employee','presence','payroll', 'tasks'));
    }

    public function presence(){
        $data = Presence::where('status', "present")
        ->selectRaw('MONTH(date) as month, YEAR(date) as year, COUNT(*) as total_present')
        ->groupBy('month','year')
        ->orderBy('month', 'asc')
        ->get();

        $temp =[];
        $i=0;

        foreach($data as $item){
            $temp[$i] = $item->total_present;
            $i++;
        }

        return response()->json($temp);
    }
}
