<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookedServicesTable extends Migration
{
    public function up()
    {
        Schema::create('booked_services', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('service_id')->nullable();
            $table->date('bookdate');
            $table->char('name', 50)->nullable();
            $table->char('number', 50)->nullable();
            $table->char('email', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();

            $table->integer('status')->nullable()->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('booked_services');
    }
}
