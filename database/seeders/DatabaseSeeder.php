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
            ClassSeeder::class,
            UserRoleSeeder::class,
            StudentClassSeeder::class,
            AssignmentSeeder::class,
            LecturerClassSeeder::class,
            CircumstanceSeeder::class,
            StudentAdvisorSeeder::class
        ]);
    }
}