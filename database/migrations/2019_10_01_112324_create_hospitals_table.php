<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHospitalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hospitals', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('cover_image')->nullable()->default('NULL');
			$table->string('logo')->nullable()->default('NULL');
			$table->string('hospital_name', 55);
			$table->string('motto')->nullable();
			$table->text('address', 65535)->nullable();
			$table->string('help_line', 15)->nullable();
			$table->string('email', 55)->nullable();
			$table->text('description', 65535)->nullable()->comment('AboutUs');
			$table->integer('area');
			$table->integer('city');
			$table->integer('country');
			$table->string('type', 155)->nullable();
			$table->string('excellence_center', 155)->nullable();
			$table->text('emergency_details', 65535)->nullable();
			$table->string('web_address', 155)->nullable();
			$table->integer('status');
			$table->timestamps();
			$table->dateTime('created_by');
			$table->dateTime('updated_by');
			$table->dateTime('deleted_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hospitals');
	}

}
