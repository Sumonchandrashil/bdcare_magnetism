<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHealthArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('health_articles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 155);
			$table->text('description', 65535);
			$table->string('image');
			$table->date('date');
			$table->integer('like');
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
		Schema::drop('health_articles');
	}

}
