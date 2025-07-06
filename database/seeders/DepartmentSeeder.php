<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('departments')->insert([
            [
                'name' => 'HR', 
                'description' => "Human Resource", 
                'status' => 'active',
                'created_at' => Carbon::now(),     
                'updated_at' => Carbon::now(),     
            ],
            [
                'name' => 'IT', 
                'description' => "Information Technology", 
                'status' => 'active',
                'created_at' => Carbon::now(),     
                'updated_at' => Carbon::now(),     
            ],
            [
                'name' => 'Sales', 
                'description' => "Purchasing and Sales", 
                'status' => 'active',
                'created_at' => Carbon::now(),     
                'updated_at' => Carbon::now(),     
            ]
        ]);

        Schema::enableForeignKeyConstraints();


    }
}
