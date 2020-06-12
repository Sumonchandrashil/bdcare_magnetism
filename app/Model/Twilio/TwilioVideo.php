<?php

namespace App\Model\Twilio;

use Illuminate\Database\Eloquent\Model;

class TwilioVideo extends Model
{
    protected $table = 'twilio_videos';

    protected $fillable = [
        'id',
        'RoomSid',
        'RoomStatus',
        'RoomName',
        'callerUserId',
        'recipientUserId',
        'AccountSid',
        'RoomDuration',
        'created_at',
        'updated_at'
    ];
}
