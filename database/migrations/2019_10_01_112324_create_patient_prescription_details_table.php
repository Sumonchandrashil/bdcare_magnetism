<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientPrescriptionDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_prescription_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('patient_id')->nullable();
			$table->integer('booking_id')->nullable();
			$table->text('history', 65535)->nullable();
			$table->text('diagonosis', 65535)->nullable();
			$table->text('description', 65535)->nullable();
			$table->text('recommendation', 65535)->nullable();
			$table->text('tests', 65535)->nullable();
			$table->integer('status');
			$table->float('rating', 2)->nullable();
			$table->timestamps();
			$table->dateTime('deleted_at');
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
		Schema::drop('patient_prescription_details');
	}

}
