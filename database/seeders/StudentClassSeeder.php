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
        ////////// TEST DATA START /////////////////
        $user_ids1 = range(6,16);
        $user_ids2 = range(17,30);
        $user_ids3 = range(31,44);

        $class_models_ids1 = range(1,2);
        $class_models_ids2 = range(3,4);
        $class_models_ids3 = range(5,6);

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

        //////////  TEST DATA END  /////////////////
    }
}
