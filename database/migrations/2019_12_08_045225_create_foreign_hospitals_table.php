<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignHospitalsTable extends Migration
{
    public function up()
    {
        Schema::create('foreign_hospitals', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('country_id')->unsigned();

            $table->string('hospital_name', 191)->nullable();
            $table->string('address', 191)->nullable();

            $table->integer('status')->nullable()->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('foreign_hospitals');
    }
}
