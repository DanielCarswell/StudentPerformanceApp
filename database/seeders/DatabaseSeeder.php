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
            PermissionSeeder::class,
            RoleSeeder::class,
            CourseSeeder::class,
            ClassSeeder::class,
            UserRoleSeeder::class,
            StudentClassSeeder::class,
            AssignmentSeeder::class,
            RolePermissionSeeder::class,
            LecturerClassSeeder::class
        ]);
    }
}
/**
 * \App\Models\User::factory(10)->create()->each(function($user){
            $user->classes()->save(\App\Models\ClassModel::factory($name))
        })
 */