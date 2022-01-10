<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            CourseSeeder::class,
            ClassSeeder::class,
            RoleSeeder::class,
            UserRoleSeeder::class,
            StudentClassSeeder::class
        ]);
    }
}
/**
 * \App\Models\User::factory(10)->create()->each(function($user){
            $user->classes()->save(\App\Models\ClassModel::factory($name))
        })
 */