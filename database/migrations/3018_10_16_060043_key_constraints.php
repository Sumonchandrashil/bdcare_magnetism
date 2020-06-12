<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('users', function ($table) {
//            $table->foreign('role_id', 'fk_users_role_id')->references('id')->on('acl_roles');
//        });
//
//        Schema::table('acl_menus', function ($table) {
//            $table->foreign('module_id', 'fk_menus_module_id')->references('id')->on('acl_modules');
//        });
//
//        Schema::table('acl_menu_permissions', function ($table) {
//            $table->foreign('role_id', 'fk_acl_menu_permissions_role_id')->references('id')->on('acl_roles');
//        });
//
//        Schema::table('acl_menu_permissions', function ($table) {
//            $table->foreign('menu_id', 'fk_acl_menu_permissions_menu_id')->references('id')->on('acl_menus');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
