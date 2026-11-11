<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave_request;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('Demo data may only be seeded in local or testing environments.');
        }

        DB::transaction(function () {
            $people = [
                ['HR', 'People Operations', 'Avery Morgan', 'hr@hris.example', 'Review the leave requests'],
                ['Developer', 'Engineering', 'Jordan Lee', 'developer@hris.example', 'Prepare the release checklist'],
                ['Sales', 'Sales', 'Riley Taylor', 'sales@hris.example', 'Follow up on the demo proposal'],
            ];

            foreach ($people as [$title, $departmentName, $name, $email, $taskTitle]) {
                $role = Role::firstOrCreate(['title' => $title]);
                $department = Department::firstOrCreate(['name' => $departmentName], ['status' => 'active']);
                $employee = Employee::firstOrCreate(['email' => $email], [
                    'name' => $name,
                    'phone' => '000-000-0000',
                    'address' => 'Demo workspace',
                    'birth_date' => '1995-01-15',
                    'hire_date' => now()->subYear()->toDateString(),
                    'salary' => 5000,
                    'department_id' => $department->id,
                    'role_id' => $role->id,
                    'status' => 'active',
                ]);

                $user = User::firstOrNew(['email' => $email]);
                $user->forceFill([
                    'name' => $name,
                    'password' => Hash::make('demo-password'),
                    'email_verified_at' => now(),
                    'employee_id' => $employee->id,
                ])->save();

                Task::firstOrCreate(['assigned_to' => $employee->id, 'title' => $taskTitle], [
                    'description' => 'A fictional task for exploring the HRIS demo.',
                    'status' => 'pending',
                    'due_date' => now()->addWeek()->toDateString(),
                ]);

                Leave_request::firstOrCreate([
                    'employee_id' => $employee->id,
                    'type' => 'vacation',
                    'start_date' => now()->addWeeks(2)->startOfWeek()->toDateString(),
                ], [
                    'end_date' => now()->addWeeks(2)->startOfWeek()->addDays(2)->toDateString(),
                    'status' => 'pending',
                ]);

                Payroll::firstOrCreate(['employee_id' => $employee->id, 'pay_date' => now()->startOfMonth()->toDateString()], [
                    'salary' => 5000,
                    'allowances' => 250,
                    'deductions' => 100,
                    'net_salary' => 5150,
                ]);

                foreach (range(0, 5) as $monthsAgo) {
                    Presence::firstOrCreate([
                        'employee_id' => $employee->id,
                        'date' => now()->startOfMonth()->subMonths($monthsAgo)->addDays(4)->toDateString(),
                    ], [
                        'check_in' => '09:00:00',
                        'check_out' => '17:00:00',
                        'status' => 'present',
                    ]);
                }
            }
        });
    }
}
