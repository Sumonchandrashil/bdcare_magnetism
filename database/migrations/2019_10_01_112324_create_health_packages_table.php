<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHealthPackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('health_packages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('package_name', 191);
			$table->integer('location');
			$table->string('age_group', 150);
			$table->integer('no_of_tests')->nullable();
			$table->string('description')->nullable();
			$table->integer('price')->nullable();
			$table->integer('discount')->nullable();
            $table->string('photo', 255)->nullable();
			$table->boolean('status')->default(1);
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('health_packages');
	}

}
