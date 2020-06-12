<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CurrencyTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(MenuPermissionTableSeeder::class);
    }
}
