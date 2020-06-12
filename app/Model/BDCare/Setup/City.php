<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $table = "cities";

    protected $fillable = [
        'id',
        'city_name',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
