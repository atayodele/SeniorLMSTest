<?php

use Illuminate\Database\Seeder;
use App\Session;

class SessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Session::truncate();
        Session::create(['name' => '2009/2010']);
        Session::create(['name' => '2010/2011']);
        Session::create(['name' => '2011/2012']);
    }
}
