<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('users')->truncate();
        DB::table('users')->insert(
            [
                ['role_id'=>'1','user_name'=>'Admin','email' => 'admin@mail.com','password' => bcrypt('123'),'remember_token' => str_random(10),'created_at' => $time],
            ]
        );
    }
}
