<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard')->middleware('role:HR,Developer,Sales');
    Route::get('/dashboard/presence', [DashboardController::class,'presence']);
    Route::resource('/employees', EmployeeController::class)->middleware('role:HR');
    Route::resource('/departments', DepartmentController::class)->middleware('role:HR');;
    Route::resource('/roles', RoleController::class)->middleware('role:HR');;
    Route::resource('/presences', PresenceController::class)->middleware('role:HR,Developer,Sales');
    Route::resource('/payrolls', PayrollController::class)->middleware('role:HR,Developer,Sales');
    Route::resource('/leave-requests', LeaveRequestController::class)->middleware('role:HR,Developer,Sales');
    Route::get('/leave-requests/confirm/{id}', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm')->middleware('role:HR');
    Route::get('/leave-requests/reject/{id}', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject')->middleware('role:HR');
    Route::resource('/tasks', TaskController::class)->middleware('role:HR,Developer,Sales');
    Route::get('/tasks/done/{tasks}', [TaskController::class,'markAsDone'])->name('tasks.done')->middleware('role:HR,Developer,Sales');
    Route::get('/tasks/pending/{tasks}', [TaskController::class,'markAsPending'])->name('tasks.pending')->middleware('role:HR,Developer,Sales');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
