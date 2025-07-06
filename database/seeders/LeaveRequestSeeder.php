<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('leave_requests')->insert([
            [
                'employee_id' => 1,
                'leave_type' => 'Sick Leave',
                'start_date' => Carbon::parse('2025-07-01'),
                'end_date' => Carbon::parse('2025-07-05'),
                'status' => 'approved',
                'reason' => 'Flu and fever',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'leave_type' => 'Vacation Leave',
                'start_date' => Carbon::parse('2025-07-10'),
                'end_date' => Carbon::parse('2025-07-15'),
                'status' => 'pending',
                'reason' => 'Family trip',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
