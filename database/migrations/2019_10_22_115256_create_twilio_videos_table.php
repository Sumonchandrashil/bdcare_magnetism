<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwilioVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('RoomSid');            
            $table->string('RoomStatus')->nullable();
            $table->string('RoomName')->comment('doctor_id');
            $table->integer('callerUserId');
            $table->integer('recipientUserId');
            $table->string('AccountSid');
            $table->string('RoomDuration');
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
        Schema::dropIfExists('twilio_videos');
    }
}
