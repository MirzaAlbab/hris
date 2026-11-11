<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-employee-record', function (User $user, int $employeeId): bool {
            return $user->employee !== null && (
                $user->employee->role?->title === 'HR'
                || (int) $user->employee_id === $employeeId
            );
        });
    }
}
