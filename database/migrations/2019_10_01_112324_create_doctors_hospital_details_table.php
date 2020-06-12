<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorsHospitalDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors_hospital_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('doctor_id');
			$table->integer('hospital_id');
			$table->time('f_time', 6);
			$table->time('s_time', 6);
			$table->string('day', 5);
			$table->integer('created_by');
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
		Schema::drop('doctors_hospital_details');
	}

}
