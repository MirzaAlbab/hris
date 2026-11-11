<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $employee = $request->user()?->employee;
        $role = $employee?->role?->title;

        abort_unless($employee && $role && in_array($role, $roles, true), 403, 'Unauthorized action.');

        $request->session()->put('role', $role);
        $request->session()->put('employee_id', $employee->id);

        return $next($request);
    }
}
