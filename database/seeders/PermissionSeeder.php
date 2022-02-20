<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'View Admin Nav',
            'slug' => 'view-admin'
        ]); 
        
        DB::table('permissions')->insert([
            'name' => 'View Students',
            'slug' => 'view-students'
        ]); 
    }
}
