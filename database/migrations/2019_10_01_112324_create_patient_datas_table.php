<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_datas', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('patient_name', 55);
			$table->string('email', 55);
			$table->text('address', 65535)->nullable();
			$table->string('contact', 15);
			$table->string('gender', 15);
			$table->integer('age');
			$table->text('details', 65535)->nullable();
			$table->string('occupation', 55);
			$table->integer('status')->nullable();
			$table->timestamps();
			$table->dateTime('deleted_at')->default('0000-00-00 00:00:00');
			$table->integer('created_by');
			$table->integer('updated_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patient_datas');
	}

}
