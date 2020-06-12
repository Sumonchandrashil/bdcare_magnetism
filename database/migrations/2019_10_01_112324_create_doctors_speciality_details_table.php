<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorsSpecialityDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors_speciality_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('doctor_id');
			$table->integer('speciality_id');
			$table->string('remarks', 55)->nullable();
			$table->dateTime('deleted_at');
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('doctors_speciality_details');
	}

}
