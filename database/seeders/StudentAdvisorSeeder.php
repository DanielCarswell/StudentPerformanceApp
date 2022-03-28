<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentAdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ////////// TEST DATA START /////////////////
        $user_ids1 = range(6,44);

        foreach($user_ids1 as $user_id)
            DB::table('student_advisor')->insert([
                'student_id' => $user_id,
                'advisor_id' => 4
            ]);
        

        //////////  TEST DATA END  /////////////////
    }
}
