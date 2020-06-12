<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    protected $table = 'countries';
    protected $guarded = [];

    protected $fillable = [
        'id',
        'country_code',
        'country_name',
        'created_at',
        'updated_at'
    ];
}
