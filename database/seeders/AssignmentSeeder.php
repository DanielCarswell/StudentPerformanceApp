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
        ////////// TEST DATA START /////////////////

        $class_ids = range(1,6);
        
        foreach($class_ids as $class_id) {
            DB::table('assignments')->insert([
                'name' => 'Assignment 1',
                'class_worth' => 5,
                'is_exam' => false,
                'class_id' => $class_id
            ]);

            DB::table('assignments')->insert([
                'name' => 'Assignment 2',
                'class_worth' => 5,
                'is_exam' => false,
                'class_id' => $class_id
            ]);

            DB::table('assignments')->insert([
                'name' => 'Assignment 3',
                'class_worth' => 5,
                'is_exam' => false,
                'class_id' => $class_id
            ]);

            DB::table('assignments')->insert([
                'name' => 'Assignment 4',
                'class_worth' => 5,
                'is_exam' => false,
                'class_id' => $class_id
            ]);

            DB::table('assignments')->insert([
                'name' => 'Class Test 1',
                'class_worth' => 10,
                'is_exam' => false,
                'class_id' => $class_id
            ]);

            DB::table('assignments')->insert([
                'name' => 'Exam',
                'class_worth' => 70,
                'is_exam' => true,
                'class_id' => $class_id
            ]);
        }

        $user_ids = range(6,33);
        $user_ids2 = range(10,24);
        $user_ids3 = range(15,44);

        foreach($user_ids as $user_id) {
            $class_id = 1;
            $assignment_ids = range(1,6);

            foreach($assignment_ids as $assignment_id)
                DB::table('student_assignment')
                ->insert([
                    'assignment_id' => $assignment_id,
                    'class_id' => $class_id,
                    'user_id' => $user_id,
                    'percent' => rand(25,100)
                ]);
        }

        foreach($user_ids as $user_id) {
            $class_id = 2;
            $assignment_ids = range(7,12);

            foreach($assignment_ids as $assignment_id)
                DB::table('student_assignment')
                ->insert([
                    'assignment_id' => $assignment_id,
                    'class_id' => $class_id,
                    'user_id' => $user_id,
                    'percent' => rand(25,100)
                ]);
        }

        foreach($user_ids2 as $user_id) {
            $class_id = 3;
            $assignment_ids = range(13,18);

            foreach($assignment_ids as $assignment_id)
                DB::table('student_assignment')
                ->insert([
                    'assignment_id' => $assignment_id,
                    'class_id' => $class_id,
                    'user_id' => $user_id,
                    'percent' => rand(25,100)
                ]);
        }

        foreach($user_ids2 as $user_id) {
            $class_id = 4;
            $assignment_ids = range(19,24);

            foreach($assignment_ids as $assignment_id)
                DB::table('student_assignment')
                ->insert([
                    'assignment_id' => $assignment_id,
                    'class_id' => $class_id,
                    'user_id' => $user_id,
                    'percent' => rand(25,100)
                ]);
        }

        foreach($user_ids3 as $user_id) {
            $class_id = 5;
            $assignment_ids = range(25,30);

            foreach($assignment_ids as $assignment_id)
                DB::table('student_assignment')
                ->insert([
                    'assignment_id' => $assignment_id,
                    'class_id' => $class_id,
                    'user_id' => $user_id,
                    'percent' => rand(25,100)
                ]);
        }

        foreach($user_ids3 as $user_id) {
            $class_id = 6;
            $assignment_ids = range(31,36);

            foreach($assignment_ids as $assignment_id)
                DB::table('student_assignment')
                ->insert([
                    'assignment_id' => $assignment_id,
                    'class_id' => $class_id,
                    'user_id' => $user_id,
                    'percent' => rand(25,100)
                ]);
        }


        //////////  TEST DATA END  /////////////////
    }
}
