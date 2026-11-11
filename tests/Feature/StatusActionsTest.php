<?php

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\Support\HrisFixtures;

uses(HrisFixtures::class);

beforeEach(function () {
    $this->withoutVite();
});

it('requires login for status changes', function (string $url) {
    $this->patch($url)->assertRedirect(route('login'));
})->with(['/tasks/done/1', '/tasks/pending/1', '/leave-requests/confirm/1', '/leave-requests/reject/1']);

it('allows HR to decide leave requests through PATCH only', function (string $action, string $status) {
    $leave = $this->employeeRecord('leave-requests', $this->employeeUser());
    $this->actingAs($this->employeeUser('HR'));

    $this->get("/leave-requests/{$action}/{$leave->id}")->assertStatus(405);
    expect($leave->fresh()->status)->toBe('pending');
    $this->patch("/leave-requests/{$action}/{$leave->id}")->assertRedirect(route('leave-requests.index'));
    expect($leave->fresh()->status)->toBe($status);
})->with([['confirm', 'confirm'], ['reject', 'reject']]);

it('forbids non-HR leave decisions', function (string $role, string $action) {
    $user = $this->employeeUser($role);
    $leave = $this->employeeRecord('leave-requests', $user);

    $this->actingAs($user)->patch("/leave-requests/{$action}/{$leave->id}")->assertForbidden();
    expect($leave->fresh()->status)->toBe('pending');
})->with(['Developer', 'Sales'])->with(['confirm', 'reject']);

it('allows an assignee or HR to change task status through PATCH only', function (string $role, string $action) {
    $user = $this->employeeUser($role);
    $owner = $role === 'HR' ? $this->employeeUser() : $user;
    $task = $this->employeeRecord('tasks', $owner);
    $task->update(['status' => $action === 'done' ? 'pending' : 'done']);
    $before = $task->status;

    $this->actingAs($user)->get("/tasks/{$action}/{$task->id}")->assertStatus(405);
    expect($task->fresh()->status)->toBe($before);
    $this->patch("/tasks/{$action}/{$task->id}")->assertRedirect(route('tasks.index'));
    expect($task->fresh()->status)->toBe($action);
})->with(['HR', 'Developer', 'Sales'])->with(['done', 'pending']);

it('denies changing another employees task status', function (string $action) {
    $task = $this->employeeRecord('tasks', $this->employeeUser());
    $task->update(['status' => $action === 'done' ? 'pending' : 'done']);
    $before = $task->status;

    $this->actingAs($this->employeeUser('Sales'))->patch("/tasks/{$action}/{$task->id}")->assertForbidden();
    expect($task->fresh()->status)->toBe($before);
})->with(['done', 'pending']);

it('returns not found for a missing status record', function (string $url) {
    $this->actingAs($this->employeeUser('HR'))->patch($url)->assertNotFound();
})->with(['/tasks/done/999', '/leave-requests/confirm/999']);

it('requires valid CSRF tokens for every status action', function (string $url) {
    // Laravel normally skips CSRF validation in tests; enable the real check here.
    $this->app->bind(ValidateCsrfToken::class, fn () => new class($this->app, $this->app['encrypter']) extends ValidateCsrfToken
    {
        protected function runningUnitTests(): bool
        {
            return false;
        }
    });
    $this->actingAs($this->employeeUser('HR'))->withSession(['_token' => 'session-token']);
    $this->patch($url)->assertStatus(419);
})->with(['/tasks/done/1', '/tasks/pending/1', '/leave-requests/confirm/1', '/leave-requests/reject/1']);

it('submits a leave request for the signed in employee even if another ID is posted', function () {
    $user = $this->employeeUser();
    $other = $this->employeeUser();
    $this->actingAs($user)->post('/leave-requests', [
        'employee_id' => $other->employee_id,
        'type' => 'vacation',
        'start_date' => '2026-12-01',
        'end_date' => '2026-12-03',
        'status' => 'confirm',
    ])->assertRedirect(route('leave-requests.index'));

    $this->assertDatabaseHas('leave_requests', ['employee_id' => $user->employee_id, 'status' => 'pending']);
    $this->assertDatabaseMissing('leave_requests', ['employee_id' => $other->employee_id]);
});

it('validates leave dates for employee submissions', function () {
    $this->actingAs($this->employeeUser())->post('/leave-requests', [
        'type' => 'vacation',
        'start_date' => '2026-12-03',
        'end_date' => '2026-12-01',
    ])->assertSessionHasErrors('end_date');

    $this->assertDatabaseCount('leave_requests', 0);
});
