<?php

namespace Tests\Support;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave_request;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;

trait HrisFixtures
{
    protected function employeeUser(string $role = 'Developer'): User
    {
        $department = Department::firstOrCreate(['name' => 'Test department']);
        $role = Role::firstOrCreate(['title' => $role]);
        $employee = Employee::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'address' => 'Test office',
            'birth_date' => '1995-01-01',
            'hire_date' => '2024-01-01',
            'salary' => 5000,
            'department_id' => $department->id,
            'role_id' => $role->id,
        ]);

        return User::factory()->create(['employee_id' => $employee->id]);
    }

    protected function employeeRecord(string $resource, User $user)
    {
        return match ($resource) {
            'tasks' => Task::create([
                'title' => 'Task for '.$user->name,
                'assigned_to' => $user->employee_id,
                'status' => 'pending',
                'due_date' => now()->addWeek()->toDateString(),
            ]),
            'leave-requests' => Leave_request::create([
                'employee_id' => $user->employee_id,
                'type' => 'vacation',
                'start_date' => now()->addWeek()->toDateString(),
                'end_date' => now()->addWeeks(2)->toDateString(),
            ]),
            'payrolls' => Payroll::create([
                'employee_id' => $user->employee_id,
                'salary' => 5000,
                'net_salary' => 5000,
                'pay_date' => now()->toDateString(),
            ]),
            'presences' => Presence::create([
                'employee_id' => $user->employee_id,
                'date' => now()->toDateString(),
                'status' => 'present',
            ]),
        };
    }
}
