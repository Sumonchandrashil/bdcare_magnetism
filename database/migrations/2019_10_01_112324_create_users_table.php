<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_name', 191);
			$table->string('email', 191)->unique();
			$table->string('mobile', 11)->unique('mobile');
			$table->string('password', 191);
			$table->string('token')->nullable();
			$table->integer('role_id')->unsigned();
			$table->string('user_photo', 191)->nullable();
			$table->string('code', 55)->nullable();
			$table->boolean('status')->nullable()->default(1);
			$table->integer('created_by')->nullable();
			$table->integer('modified_by')->nullable();
			$table->string('remember_token', 100)->nullable();
            $table->boolean('online_activity')->default(0);
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
		Schema::drop('users');
	}

}
