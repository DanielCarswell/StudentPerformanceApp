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
            'firstname' => 'admin',
            'lastname' => 'superuser',
            'email' => 'admin@studentperformance.net',
            'password' => Hash::make('admin')
        ]); 

        ////////// TEST DATA START /////////////////
        DB::table('users')->insert([
            'fullname' => 'lecturer Example',
            'username' => 'lecturer',
            'firstname' => 'lecturer',
            'lastname' => 'Example',
            'email' => 'lecturer@studentperformance.net',
            'password' => Hash::make('lecturer')
        ]); 

        DB::table('users')->insert([
            'fullname' => 'John Doe',
            'username' => 'JD67890',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@studentperformance.net',
            'password' => Hash::make('JohnDoe')
        ]); 

        DB::table('users')->insert([
            'fullname' => 'Jane Doe',
            'username' => 'JD12345',
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'janedoe@studentperformance.net',
            'password' => Hash::make('JaneDoe')
        ]); 

        \App\Models\User::factory(39)->create();

        DB::table('users')->insert([
            'fullname' => 'test',
            'username' => 'test acc',
            'firstname' => 'test',
            'lastname' => 'acc',
            'email' => 'test@studentperformance.net',
            'password' => Hash::make('testAcc12345!')
        ]);

        //////////  TEST DATA END  /////////////////
    }
}
