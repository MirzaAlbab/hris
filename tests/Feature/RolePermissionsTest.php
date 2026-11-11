<?php

use App\Models\User;
use Tests\Support\HrisFixtures;

uses(HrisFixtures::class);

beforeEach(function () {
    $this->withoutVite();
});

it('redirects guests to login', function (string $url) {
    $this->get($url)->assertRedirect(route('login'));
})->with(['/dashboard', '/tasks', '/leave-requests', '/employees', '/dashboard/presence']);

it('denies users without an employee instead of crashing', function () {
    $this->actingAs(User::factory()->create())->get('/dashboard')->assertForbidden();
});

it('denies users whose employee or role has been deleted', function (string $record) {
    $user = $this->employeeUser();
    $employee = $user->employee;
    ($record === 'employee' ? $employee : $employee->role)->delete();

    $this->actingAs($user->fresh())->get('/dashboard')->assertForbidden();
})->with(['employee', 'role']);

it('does not trust an HR role supplied in the session', function () {
    $this->actingAs($this->employeeUser('Sales'))
        ->withSession(['role' => 'HR'])
        ->get('/employees')->assertForbidden();
});

it('allows HR to manage employee directories', function (string $url) {
    $this->actingAs($this->employeeUser('HR'))->get($url)->assertOk();
})->with(['/employees', '/departments', '/roles', '/tasks/create', '/payrolls/create']);

it('blocks non-HR access to management routes', function (string $role, string $url) {
    $this->actingAs($this->employeeUser($role))->get($url)->assertForbidden();
})->with(['Developer', 'Sales'])->with(['/employees', '/departments', '/roles', '/tasks/create', '/payrolls/create']);

it('blocks non-HR record management even when they own the record', function (string $resource, string $method) {
    $user = $this->employeeUser();
    $record = $this->employeeRecord($resource, $user);

    $this->actingAs($user)->{$method}("/{$resource}/{$record->id}", [])->assertForbidden();
    expect($record->fresh()->deleted_at)->toBeNull();
})->with(['tasks', 'leave-requests', 'payrolls', 'presences'])->with(['put', 'delete']);

it('blocks non-HR creation of managed tasks and payrolls', function (string $resource) {
    $this->actingAs($this->employeeUser())->post('/'.$resource, [])->assertForbidden();
})->with(['tasks', 'payrolls']);

it('allows employees to view their own records and HR to view any record', function (string $resource) {
    $employee = $this->employeeUser();
    $record = $this->employeeRecord($resource, $employee);

    $this->actingAs($employee)->get("/{$resource}/{$record->id}")->assertOk();
    $this->actingAs($this->employeeUser('HR'))->get("/{$resource}/{$record->id}")->assertOk();
})->with(['tasks', 'leave-requests', 'payrolls', 'presences']);

it('denies access to another employees records', function (string $resource, string $role) {
    $record = $this->employeeRecord($resource, $this->employeeUser());

    $this->actingAs($this->employeeUser($role))->get("/{$resource}/{$record->id}")->assertForbidden();
})->with(['tasks', 'leave-requests', 'payrolls', 'presences'])->with(['Developer', 'Sales']);

it('lists only the signed in employees tasks', function () {
    $user = $this->employeeUser();
    $own = $this->employeeRecord('tasks', $user);
    $other = $this->employeeRecord('tasks', $this->employeeUser());

    $this->actingAs($user)->get('/tasks')->assertOk()->assertSee($own->title)->assertDontSee($other->title);
    $this->get('/dashboard')->assertOk()->assertSee($own->title)->assertDontSee($other->title);
});

it('returns twelve monthly attendance counts scoped to the current employee', function () {
    $this->travelTo(now()->setDate(2026, 6, 15));
    $user = $this->employeeUser();
    $this->employeeRecord('presences', $user);
    $this->employeeRecord('presences', $this->employeeUser());
    $expected = array_fill(0, 12, 0);
    $expected[5] = 1;

    $this->actingAs($user)->get('/dashboard/presence')->assertOk()->assertExactJson($expected);
    $expected[5] = 2;
    $this->actingAs($this->employeeUser('HR'))->get('/dashboard/presence')->assertOk()->assertExactJson($expected);
});
