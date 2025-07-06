<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableforeignKeyConstraints();
        $faker = Faker::create();
        
        DB::table('payrolls')->insert([
            [
                'employee_id' => 1,
                'salary' => $faker->numberBetween(30000, 100000),
                'bonus' => $faker->numberBetween(1000, 5000),
                'deductions' => $faker->numberBetween(500, 2000),
                'net_pay' => $faker->numberBetween(25000, 95000),
                'pay_date' => Carbon::parse('2025-07-15'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'salary' => $faker->numberBetween(30000, 100000),
                'bonus' => $faker->numberBetween(1000, 5000),
                'deductions' => $faker->numberBetween(500, 2000),
                'net_pay' => $faker->numberBetween(25000, 95000),
                'pay_date' => Carbon::parse('2025-07-16'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
        Schema::enableForeignKeyConstraints();

    }
}
