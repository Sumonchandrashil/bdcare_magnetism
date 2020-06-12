<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorsDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors_datas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('doctor_name', 55);
			$table->integer('visiting_fees')->default(0);
			$table->integer('messaging_fees')->default(0);
			$table->string('emergency_contact', 50)->nullable();
			$table->string('email', 55);
			$table->string('gender', 7)->nullable();
			$table->text('address', 65535)->nullable();
			$table->text('bio_data', 65535)->nullable();
			$table->string('current_designation', 191)->nullable();
			$table->decimal('year_of_experience', 4)->nullable();
			$table->string('bmdc_reg_no', 55);
			$table->string('bmdc_reg_year', 15);
			$table->string('bmdc_doc')->nullable();
			$table->string('passport_nid')->nullable();
			$table->float('rating')->nullable();
			$table->boolean('status')->nullable()->default(0);
			$table->boolean('premium')->nullable()->default(0)->comment('No=0; Yes=1');// No=0; Yes=1
			$table->integer('online')->default(0);
			$table->text('summary', 65535)->nullable();
			$table->timestamps();
			$table->dateTime('deleted_at');
			$table->string('created_by', 155);
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
		Schema::drop('doctors_datas');
	}

}
