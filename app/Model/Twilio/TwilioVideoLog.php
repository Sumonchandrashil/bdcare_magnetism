<?php

namespace App\Model\Twilio;

use Illuminate\Database\Eloquent\Model;

class TwilioVideoLog extends Model
{
    protected $table = 'twilio_video_logs';

    protected $fillable = [
        'id',
        'twilio_video_id',
        'SequenceNumber',
        'ParticipantStatus',
        'ParticipantIdentity',
        'StatusCallbackEvent',
        'TrackKind',
        'ParticipantDuration',
        'RawData',
        'created_at',
        'updated_at'
    ];
}
