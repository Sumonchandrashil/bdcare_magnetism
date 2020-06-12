<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('acl_roles')->truncate();
        DB::table('acl_roles')->insert(
            [
                ['role_name' => 'Super Admin','created_at'=>$time],
                ['role_name' => 'Doctor','created_at'=>$time],
                ['role_name' => 'Paitent','created_at'=>$time],
            ]

        );
    }
}
