<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('acl_menu_permissions')->truncate();
        DB::table('acl_menu_permissions')->insert(
            [
                ['role_id'=>'1','menu_id'=>'9','created_at' => $time],
            ]
        );
    }
}
