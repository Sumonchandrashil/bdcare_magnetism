<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('currencies')->truncate();
        DB::table('currencies')->insert(
            [
                ['name'=>'Dollars','symbol'=>'$','created_at' => $time],
                ['name'=>'Pounds','symbol'=>'£','created_at' => $time],
                ['name'=>'Euro','symbol'=>'€','created_at' => $time],
            ]
        );
    }
}
