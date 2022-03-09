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
        $user_ids1 = range(11,20);
        $user_ids2 = range(21,30);

        foreach($user_ids1 as $user_id)
            DB::table('student_advisor')->insert([
                'student_id' => $user_id,
                'advisor_id' => 3
            ]);
        
            foreach($user_ids2 as $user_id)
            DB::table('student_advisor')->insert([
                'student_id' => $user_id,
                'advisor_id' => 4
            ]);
    }
}
