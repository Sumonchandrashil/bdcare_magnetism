<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAclRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acl_roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('role_name', 191)->unique();
			$table->boolean('status')->default(1);
			$table->integer('created_by')->nullable();
			$table->integer('modified_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('acl_roles');
	}

}
