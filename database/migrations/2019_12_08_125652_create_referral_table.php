<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReferralTable extends Migration
{
    public function up()
    {
        Schema::create('referral', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('patient_name', 191)->nullable();
            $table->integer('patient_age')->nullable();
            $table->string('care_giver_name', 191)->nullable();
            $table->integer('care_giver_age')->nullable();
            $table->string('passport_no', 191)->nullable();
            $table->integer('wheel_chair')->default(0)->nullable();
            $table->string('address', 191)->nullable();
            $table->string('mobile_number', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->date('date_of_travel')->nullable();
            $table->integer('foreign_hospital_id')->unsigned();
            $table->string('medical_report', 191)->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('referral');
    }
}
