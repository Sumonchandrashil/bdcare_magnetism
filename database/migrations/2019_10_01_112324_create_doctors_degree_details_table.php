<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorsDegreeDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors_degree_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('doctor_id');
			$table->integer('degree_id');
			$table->string('institute', 55);
			$table->string('passing_year', 5)->nullable();
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
		Schema::drop('doctors_degree_details');
	}

}
