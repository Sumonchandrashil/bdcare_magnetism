<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientAppointmentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_appointment_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('patient_id');
			$table->integer('doctor_id');
			$table->string('hospital_id', 55);
			$table->time('schedule', 6);
			$table->string('day', 5);
			$table->date('date');
			$table->timestamps();
			$table->dateTime('deleted_at');
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->integer('deleted_by');
			$table->integer('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patient_appointment_details');
	}

}
