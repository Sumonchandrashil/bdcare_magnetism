<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHospitalFacilityDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hospital_facility_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('hospital_id')->unsigned();
			$table->integer('facility_id')->unsigned();
			$table->string('remarks', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hospital_facility_details');
	}

}
