<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwilioVideoLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_video_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('twilio_video_id')->unsigned();
            $table->string('SequenceNumber');
            $table->string('ParticipantStatus');
            $table->string('ParticipantIdentity')->comment('UserId');
            $table->string('StatusCallbackEvent')->nullable();
            $table->string('TrackKind')->nullable();
            $table->string('ParticipantDuration')->nullable(); 
            $table->text('RawData')->nullable(); 
            $table->timestamps();

            $table->foreign('twilio_video_id')->references('id')->on('twilio_videos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twilio_video_logs');
    }
}
