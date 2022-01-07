<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Seed the roles table.
     *
     * @return void
     */
    public function run()
    {
        //Creates Roles to be assigned to Users.
        DB::table('roles')->insert([
            'name' => 'Admin'
        ]); 

        DB::table('roles')->insert([
            'name' => 'Moderator'
        ]); 

        DB::table('roles')->insert([
            'name' => 'Lecturer'
        ]); 

        DB::table('roles')->insert([
            'name' => 'Staff'
        ]);
        
        DB::table('roles')->insert([
            'name' => 'Student Helper'
        ]);

        DB::table('roles')->insert([
            'name' => 'Student'
        ]); 

        DB::table('roles')->insert([
            'name' => 'Unverified'
        ]); 
    }
}
