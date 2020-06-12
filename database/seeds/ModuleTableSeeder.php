<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('acl_modules')->truncate();
        DB::table('acl_modules')->insert(
            [
                ['id' => 1, 'module_name' => 'Administration', 'icon_class' => 'flaticon-users', 'created_at' => $time],
                ['id' => 2, 'module_name' => 'Setup', 'icon_class' => 'flaticon-share', 'created_at' => $time],
                ['id' => 3, 'module_name' => 'Doctor Profile', 'icon_class' => 'flaticon-share', 'created_at' => $time],
                ['id' => 4, 'module_name' => 'Patient Profile', 'icon_class' => 'flaticon-share', 'created_at' => $time],
                ['id' => 5, 'module_name' => 'Packages and Service', 'icon_class' => 'flaticon-share', 'created_at' => $time],
                ['id' => 6, 'module_name' => 'Report', 'icon_class' => 'flaticon-share', 'created_at' => $time],
            ]
        );
    }
}
