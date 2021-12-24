<?php

use Illuminate\Database\Seeder;
use App\Level;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::truncate();
        Level::create(['name' => '100L']);
        Level::create(['name' => '200L']);
        Level::create(['name' => '300L']);
        Level::create(['name' => '400L']);
        Level::create(['name' => '500L']);
    }
}
