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

        $user_ids = range(5,13);
        $user_ids2 = range(5,23);
        $user_ids3 = range(14,33);
        $user_ids4 = range(30,43);

        foreach($user_ids as $user_id) {
            $class_id = range(1,2);
            $assignment_ids = range(1,12);

            foreach($class_id as $id) {
                foreach($assignment_ids as $assignment_id)
                    DB::table('student_assignment')
                    ->insert([
                        'assignment_id' => $assignment_id,
                        'class_id' => $id,
                        'user_id' => $user_id,
                        'percent' => rand(25,100)
                    ]);
            }

            $assignment_id += 1;
        }

        foreach($user_ids2 as $user_id) {
            $class_id = range(3,4);
            $assignment_ids = range(13,24);

            foreach($class_id as $id) {
                foreach($assignment_ids as $assignment_id)
                    DB::table('student_assignment')
                    ->insert([
                        'assignment_id' => $assignment_id,
                        'class_id' => $id,
                        'user_id' => $user_id,
                        'percent' => rand(25,100)
                    ]);
            }

            $assignment_id += 1;
        }

        foreach($user_ids3 as $user_id) {
            $class_id = range(5,6);
            $assignment_ids = range(25,36);

            foreach($class_id as $id) {
                foreach($assignment_ids as $assignment_id)
                    DB::table('student_assignment')
                    ->insert([
                        'assignment_id' => $assignment_id,
                        'class_id' => $id,
                        'user_id' => $user_id,
                        'percent' => rand(25,100)
                    ]);
            }
        }
    }
}
