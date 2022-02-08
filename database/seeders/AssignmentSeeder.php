<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignments')->insert([
            'name' => 'Assignment 1',
            'class_worth' => 5,
            'is_exam' => false,
            'class_id' => 1
        ]);

        DB::table('assignments')->insert([
            'name' => 'Assignment 2',
            'class_worth' => 5,
            'is_exam' => false,
            'class_id' => 1
        ]);

        DB::table('assignments')->insert([
            'name' => 'Assignment 3',
            'class_worth' => 5,
            'is_exam' => false,
            'class_id' => 1
        ]);

        DB::table('assignments')->insert([
            'name' => 'Assignment 4',
            'class_worth' => 5,
            'is_exam' => false,
            'class_id' => 1
        ]);

        DB::table('assignments')->insert([
            'name' => 'Class Test 1',
            'class_worth' => 10,
            'is_exam' => false,
            'class_id' => 1
        ]);

        DB::table('assignments')->insert([
            'name' => 'Exam',
            'class_worth' => 70,
            'is_exam' => true,
            'class_id' => 1
        ]);
    }
}
