<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $timestamps = false;
    protected $table = 'currencies';
    protected $guarded = [];

    protected $fillable = [
        'id',
        'name',
        'symbol',
        'status',
        'created_at',
        'updated_at'
    ];
}
