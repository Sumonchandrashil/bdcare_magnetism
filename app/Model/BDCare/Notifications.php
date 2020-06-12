<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = "notifications";

    protected $fillable = [
        'id',
        'title',
        'details',
        'key_note',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'created_for',
        'updated_by'
    ];
}
