<?php

use App\Models\Employee;
use App\Models\User;
use Database\Seeders\DemoSeeder;
use Illuminate\Support\Facades\Hash;

it('seeds three linked demo accounts and can be run twice', function () {
    $this->travelTo(now()->setDate(2026, 6, 15));
    $this->seed(DemoSeeder::class);
    $this->seed(DemoSeeder::class);

    $this->assertDatabaseCount('users', 3);
    $this->assertDatabaseCount('employees', 3);
    $this->assertDatabaseCount('tasks', 3);
    $this->assertDatabaseCount('leave_requests', 3);
    $this->assertDatabaseCount('payrolls', 3);
    $this->assertDatabaseCount('presences', 18);

    foreach (['hr' => 'HR', 'developer' => 'Developer', 'sales' => 'Sales'] as $account => $role) {
        $user = User::where('email', $account.'@hris.example')->firstOrFail();
        expect(Hash::check('demo-password', $user->password))->toBeTrue();
        expect($user->employee->role->title)->toBe($role);
        $this->post('/login', ['email' => $user->email, 'password' => 'demo-password'])->assertRedirect('/dashboard');
        $this->post('/logout');
    }
});

it('refuses to seed demo credentials in production', function () {
    $this->app->instance('env', 'production');

    expect(fn () => (new DemoSeeder)->run())->toThrow(RuntimeException::class);
    expect(User::count())->toBe(0);
    expect(Employee::count())->toBe(0);
});
