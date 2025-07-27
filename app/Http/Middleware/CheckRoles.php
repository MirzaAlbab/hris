<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Employee;

use function Pest\Laravel\put;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $employeeID = Auth::user()->employee_id;
        $employee = Employee::find($employeeID);

        $request->session()->put('role', $employee->role->title);
        $request->session()->put('employeeID', $employee->id);

        if(!in_array($employee->role->title, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
