<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Classe;

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

        $student_ids = range(3,40);

        foreach($student_ids as $student_id) {
            DB::table('student_assignment')
            ->insert([
                'assignment_id' => 1,
                'class_id' => 1,
                'user_id' => $student_id,
                'percent' => rand(25,100)
            ]);

            DB::table('student_assignment')
            ->insert([
                'assignment_id' => 2,
                'class_id' => 1,
                'user_id' => $student_id,
                'percent' => rand(25,100)
            ]);

            DB::table('student_assignment')
            ->insert([
                'assignment_id' => 3,
                'class_id' => 1,
                'user_id' => $student_id,
                'percent' => rand(25,100)
            ]);

            DB::table('student_assignment')
            ->insert([
                'assignment_id' => 4,
                'class_id' => 1,
                'user_id' => $student_id,
                'percent' => rand(25,100)
            ]);

            DB::table('student_assignment')
            ->insert([
                'assignment_id' => 5,
                'class_id' => 1,
                'user_id' => $student_id,
                'percent' => rand(25,100)
            ]);
        }
    }
}
