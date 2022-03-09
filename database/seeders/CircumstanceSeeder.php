<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CircumstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('circumstances')->insert([
            'name' => 'Depression',
            'information' => 'Dealing with Depression can be hard and mentally draining, there are many 
            online sources that can advise you and help ease the burden.'
        ]);

        DB::table('circumstance_links')->insert([
            'circumstance_id' => 1,
            'link' => 'https://www.nhs.uk/mental-health/conditions/clinical-depression/overview/',
            'id_of_user_added_by' => 1
        ]);

        DB::table('circumstance_links')->insert([
            'circumstance_id' => 1,
            'link' => 'https://www.nhsinform.scot/illnesses-and-conditions/mental-health/depression',
            'id_of_user_added_by' => 1
        ]);

        DB::table('circumstance_links')->insert([
            'circumstance_id' => 1,
            'link' => 'https://www.verywellmind.com/tips-for-living-with-depression-1066834',
            'id_of_user_added_by' => 1
        ]);

        for ($i = 10; $i <= 20; $i++) {
            DB::table('student_circumstance')->insert([
                'circumstance_id' => 1,
                'student_id' => $i
            ]);
        }
    }
}
