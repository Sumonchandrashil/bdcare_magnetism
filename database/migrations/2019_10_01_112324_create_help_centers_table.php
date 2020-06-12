<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHelpCentersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('help_centers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 191);
			$table->string('email', 155);
			$table->date('entry_date')->nullable();
			$table->string('terms_condition');
			$table->text('reply', 65535)->nullable();
			$table->boolean('status')->default(1);
			$table->float('rating', 2)->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('help_centers');
	}

}
