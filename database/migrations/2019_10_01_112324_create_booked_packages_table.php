<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookedPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('booked_packages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('package_id')->nullable();

            $table->date('book_date')->nullable();
            $table->char('name', 50)->nullable();
            $table->text('address')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender', 50)->nullable();
            $table->char('number', 50)->nullable();
            $table->char('email', 50)->nullable();
            $table->tinyInteger('sample_collection')->nullable();

            $table->integer('status')->nullable()->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('booked_packages');
    }
}
