<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StudentClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids1 = range(5,13);
        $user_ids2 = range(14,23);
        $user_ids3 = range(24,33);
        $user_ids4 = range(34,43);

        $class_models_ids1 = range(1,10);
        $class_models_ids2 = range(11,20);
        $class_models_ids3 = range(21,30);
        $class_models_ids4 = range(31,40);

        foreach($user_ids1 as $user_id)
            foreach($class_models_ids1 as $class_models_id)
                DB::table('student_class')->insert([
                    'student_id' => $user_id,
                    'class_id' => $class_models_id,
                    'grade' => rand(20,100),
                    'attendance' => rand(10,100)
                ]);  

        foreach($user_ids2 as $user_id)
            foreach($class_models_ids2 as $class_models_id)
                DB::table('student_class')->insert([
                    'student_id' => $user_id,
                    'class_id' => $class_models_id,
                    'grade' => rand(20,100),
                    'attendance' => rand(10,100)
                ]);  

        foreach($user_ids3 as $user_id)
            foreach($class_models_ids3 as $class_models_id)
                DB::table('student_class')->insert([
                    'student_id' => $user_id,
                    'class_id' => $class_models_id,
                    'grade' => rand(20,100),
                    'attendance' => rand(10,100)
                ]);  

        foreach($user_ids4 as $user_id)
            foreach($class_models_ids4 as $class_models_id)
                DB::table('student_class')->insert([
                    'student_id' => $user_id,
                    'class_id' => $class_models_id,
                    'grade' => rand(20,100),
                    'attendance' => rand(10,100)
                ]);  
    }
}
