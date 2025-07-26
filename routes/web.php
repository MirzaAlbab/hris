<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

// handle employee
Route::resource('/employees', EmployeeController::class);
Route::resource('/departments', DepartmentController::class);
Route::resource('/roles', RoleController::class);
Route::resource('/presences', PresenceController::class);
// handle task
Route::resource('/tasks', TaskController::class);
Route::get('/tasks/done/{tasks}', [TaskController::class,'markAsDone'])->name('tasks.done');
Route::get('/tasks/pending/{tasks}', [TaskController::class,'markAsPending'])->name('tasks.pending');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
