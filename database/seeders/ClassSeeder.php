<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Seed the class_models table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->insert([
            'name' => 'Test Class',
        ]);

        $names = [
            'Information Access', 'Cyber Security',
            'Hair styling', 'User Testing',
            'Criminal Psychology', 'Accounting'
        ];

        foreach($names as $name) {
            DB::table('classes')->insert([
                'name' => $name,
            ]);  
        }  
    }
}
