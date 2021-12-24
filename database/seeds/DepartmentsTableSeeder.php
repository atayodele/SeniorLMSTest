<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::truncate();
        Department::create(['name' => 'Computer Science']);
        Department::create(['name' => 'Social Science']);
        Department::create(['name' => 'Management']);
    }
}
