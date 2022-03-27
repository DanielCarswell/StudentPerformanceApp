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
            'firstname' => 'admin',
            'lastname' => 'superuser',
            'email' => 'admin@studentperformance.net',
            'password' => Hash::make('admin')
        ]); 

        ////////// TEST DATA START /////////////////     
        DB::table('users')->insert([
            'fullname' => 'lecturer Example',
            'firstname' => 'lecturer',
            'lastname' => 'Example',
            'email' => 'lecturer@studentperformance.net',
            'password' => Hash::make('lecturer')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Example Advisor',
            'firstname' => 'Advisor',
            'lastname' => 'Example',
            'email' => 'advisor@studentperformance.net',
            'password' => Hash::make('advisor')
        ]); 

        DB::table('users')->insert([
            'fullname' => 'John Doe',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@studentperformance.net',
            'password' => Hash::make('JohnDoe')
        ]); 

        DB::table('users')->insert([
            'fullname' => 'test',
            'firstname' => 'test',
            'lastname' => 'acc',
            'email' => 'test@studentperformance.net',
            'password' => Hash::make('testAcc12345!')
        ]);

        \App\Models\User::factory(39)->create();

        //////////  TEST DATA END  /////////////////
    }
}
