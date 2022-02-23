<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fullname' => 'admin',
            'username' => 'superuser',
            'email' => 'admin@studentperformance.net',
            'password' => Hash::make('admin')
        ]); 

        DB::table('users')->insert([
            'fullname' => 'lecturer',
            'username' => 'lecturer',
            'email' => 'lecturer@studentperformance.net',
            'password' => Hash::make('lecturer')
        ]); 

        \App\Models\User::factory(39)->create();
    }
}
