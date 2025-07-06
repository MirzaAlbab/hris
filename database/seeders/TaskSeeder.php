<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $faker = Faker::create();

        DB::table('tasks')->insert([
            [
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(2),
                'status' => 'pending',
                'assigned_to' => 1,
                'due_date'=> Carbon::parse('2025-02-15'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(2),
                'status' => 'pending',
                'assigned_to' => 1,
                'due_date'=> Carbon::parse('2025-02-15'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
