<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);

        ////////// TEST DATA START /////////////////

        DB::table('user_role')->insert([
            'user_id' => 2,
            'role_id' => 3
        ]);

        DB::table('user_role')->insert([
            'user_id' => 3,
            'role_id' => 4
        ]);

        DB::table('user_role')->insert([
            'user_id' => 4,
            'role_id' => 4
        ]);

        DB::table('user_role')->insert([
            'user_id' => 5,
            'role_id' => 3
        ]);

        $user_ids = range(6,44);

        foreach($user_ids as $user_id) {
            DB::table('user_role')->insert([
                'user_id' => $user_id,
                'role_id' => 6
            ]);  
        }

        //////////  TEST DATA END  /////////////////
    }
}
