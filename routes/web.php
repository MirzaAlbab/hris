<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:HR,Developer,Sales'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/presence', [DashboardController::class, 'presence']);

    Route::get('/tasks/create', [TaskController::class, 'create'])->middleware('role:HR')->name('tasks.create');
    Route::resource('/tasks', TaskController::class)->only(['index', 'show']);
    Route::patch('/tasks/done/{tasks}', [TaskController::class, 'markAsDone'])->name('tasks.done');
    Route::patch('/tasks/pending/{tasks}', [TaskController::class, 'markAsPending'])->name('tasks.pending');
    Route::resource('/leave-requests', LeaveRequestController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('/presences', PresenceController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('/payrolls/create', [PayrollController::class, 'create'])->middleware('role:HR')->name('payrolls.create');
    Route::resource('/payrolls', PayrollController::class)->only(['index', 'show']);

    Route::middleware('role:HR')->group(function () {
        Route::resource('/employees', EmployeeController::class);
        Route::resource('/departments', DepartmentController::class);
        Route::resource('/roles', RoleController::class);
        Route::resource('/tasks', TaskController::class)->except(['index', 'show', 'create']);
        Route::resource('/leave-requests', LeaveRequestController::class)->except(['index', 'create', 'store', 'show']);
        Route::patch('/leave-requests/confirm/{id}', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm');
        Route::patch('/leave-requests/reject/{id}', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');
        Route::resource('/presences', PresenceController::class)->except(['index', 'create', 'store', 'show']);
        Route::resource('/payrolls', PayrollController::class)->except(['index', 'show', 'create']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
