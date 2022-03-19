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
        \DB::table('student_class')->insert([
            'student_id' => 5,
            'class_id' => 1,
            'grade' => rand(20,100),
            'attendance' => rand(10,100)
        ]);

        $user_ids1 = range(5,13);
        $user_ids2 = range(5,23);
        $user_ids3 = range(14,33);
        $user_ids4 = range(30,43);

        $class_models_ids1 = range(2,3);
        $class_models_ids2 = range(4,5);
        $class_models_ids3 = range(6,7);

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
    }
}
