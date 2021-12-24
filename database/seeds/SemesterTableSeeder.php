<?php

use Illuminate\Database\Seeder;
use App\Semester;

class SemesterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semester::truncate();
        Semester::create(['name' => 'First Semester']);
        Semester::create(['name' => 'Second Semester']);
    }
}
