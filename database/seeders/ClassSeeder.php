<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Seed the class_models table.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'CS101 Computing A', 'CS102 Computing B',
            'CS103 Computing C', 'CS104 Computing D',
            'CS105 Computing E', 'CS106 Computing F',
            'CS107 Computing G', 'CS108 Computing H',
            'CS109 Computing I', 'CS110 Computing J'
        ];

        foreach($names as $name) {
            DB::table('class_models')->insert([
                'name' => $name,
                'year' => 1
            ]);  
        }

        $names = [
            'CS201 Computing A', 'CS202 Computing B',
            'CS203 Computing C', 'CS204 Computing D',
            'CS205 Computing E', 'CS206 Computing F',
            'CS207 Computing G', 'CS208 Computing H',
            'CS209 Computing I', 'CS210 Computing J'
        ];

        foreach($names as $name) {
            DB::table('class_models')->insert([
                'name' => $name,
                'year' => 2
            ]);  
        }

        $names = [
            'CS301 Computing A', 'CS302 Computing B',
            'CS303 Computing C', 'CS304 Computing D',
            'CS305 Computing E', 'CS306 Computing F',
            'CS307 Computing G', 'CS308 Computing H',
            'CS309 Computing I', 'CS310 Computing J'
        ];

        foreach($names as $name) {
            DB::table('class_models')->insert([
                'name' => $name,
                'year' => 3
            ]);  
        }

        $names = [
            'CS401 Computing A', 'CS402 Computing B',
            'CS403 Computing C', 'CS404 Computing D',
            'CS405 Computing E', 'CS406 Computing F',
            'CS407 Computing G', 'CS408 Computing H',
            'CS409 Computing I', 'CS410 Computing J'
        ];

        foreach($names as $name) {
            DB::table('class_models')->insert([
                'name' => $name,
                'year' => 4
            ]);  
        }
    }
}
