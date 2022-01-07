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
        $user_ids = range(2,41);

        DB::table('user_role')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);

        foreach($user_ids as $user_id)
            DB::table('user_role')->insert([
                'user_id' => $user_id,
                'role_id' => 2
            ]);  
    }
}
