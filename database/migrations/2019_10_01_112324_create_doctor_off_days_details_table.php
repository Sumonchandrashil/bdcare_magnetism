<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorOffDaysDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctor_off_days_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('doctor_id');
			$table->date('doctor_off_day');
			$table->integer('created_by');
			$table->integer('updated_by');
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
		Schema::drop('doctor_off_days_details');
	}

}
