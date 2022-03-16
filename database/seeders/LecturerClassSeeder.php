<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LecturerClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class_models_ids = range(1,6);

        foreach($class_models_ids as $class_models_id)
            DB::table('lecturer_class')->insert([
                'lecturer_id' => 2,
                'class_id' => $class_models_id
            ]);   
    }
}
