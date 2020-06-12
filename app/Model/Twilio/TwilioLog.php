<?php

namespace App\Model\Twilio;

use Illuminate\Database\Eloquent\Model;

class TwilioLog extends Model
{
    public $table = 'twilio_logs';

    protected $fillable = [
        'id',
        'type',
        'posted_data',
        'created_at',
        'updated_at'
    ];
}
