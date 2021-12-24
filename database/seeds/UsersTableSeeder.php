<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Department;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();
        $adminRole = Role::where('name', 'admin')->first();
        $password = 'password';

        $admin = User::create([
            'fname' => 'Admin',
            'lname' => 'User',
            'email' => 'admin@admin.com',
            'password' => Hash::make($password)
        ]);

        $admin->roles()->attach($adminRole);
    }
}
