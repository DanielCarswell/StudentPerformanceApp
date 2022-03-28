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

        $user_ids = range(6,16);
        $user_ids2 = range(17,30);
        $user_ids3 = range(31,44);

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

        $all_ids = range(6,44);
        foreach($all_ids as $id)
            $this->update_student_grades($id);
        //////////  TEST DATA END  /////////////////
    }

    /**
    * Upgrades students grade for the full class by calculating total grade by all assignments
    * meaning if a student has done 1 assignment and got 50%, their grade will be 50% or an assignment
    * with 50% and one with 100% 20% class worth on both then 75% class grade.
    *
    * @param int student_id
    * @return to.method.call  
    */
    public function update_student_grades(int $student_id) {
        //Gets all of the students classes.
        $classes = \DB::table('classes')
        ->select('classes.id', 'classes.name', 'student_class.grade', 'student_class.attendance')
        ->from('classes')
        ->join('student_class', 'student_class.class_id', '=', 'classes.id')
        ->join('users', 'users.id', '=', 'student_class.student_id')
        ->where('users.id', $student_id)
        ->get();

        //For all of the students classes.
        foreach($classes as $class) {
            //Gets all students assignments for the class.
            $assignments = \DB::table('assignments')
            ->select('assignments.id', 'student_assignment.percent', 'assignments.class_worth')
            ->from('assignments')
            ->join('student_assignment', 'student_assignment.assignment_id', '=', 'assignments.id')
            ->join('users', 'users.id', '=', 'student_assignment.user_id')
            ->join('classes', 'student_assignment.class_id', '=', 'classes.id')
            ->where('users.id', $student_id)
            ->where('classes.id', $class->id)
            ->get();

            //Initializing local varaibles.
            $class_grade = 0.0;
            $total_class_worth = 0.0;

            //for all assignments, add class_worth and class_grade.
            foreach($assignments as $assignment) {
                if($assignment->percent == 0)
                    continue;
                $total_class_worth += $assignment->class_worth;
                $class_grade += ($assignment->percent * ($assignment->class_worth/100));
            }

            //Update class grade by total class worth for current overall grade.
            if($total_class_worth != 0)
                \DB::table('student_class')
                    ->where('class_id', $class->id)
                    ->where('student_id', $student_id)
                    ->update([
                        'grade' => (($class_grade / $total_class_worth) * 100)
                    ]);
        }

        return;
    }
}
