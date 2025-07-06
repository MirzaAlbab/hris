<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('presences')->insert([
            [
                'employee_id' => 1,
                'check_in' => Carbon::parse('2025-07-15 09:00:00'),
                'check_out' => Carbon::parse('2025-07-15 17:00:00'),
                'date' => Carbon::parse('2025-07-15'),
                'status' => 'present',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'check_in' => Carbon::parse('2025-07-15 09:00:00'),
                'check_out' => Carbon::parse('2025-07-15 17:00:00'),
                'date' => Carbon::parse('2025-07-15'),
                'status' => 'present',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        Schema::enableForeignKeyConstraints();

    }
}
