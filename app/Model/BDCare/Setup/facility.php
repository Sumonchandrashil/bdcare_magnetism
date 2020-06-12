<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/
    protected $table = "facilities";

    protected $fillable = [
        'id',
        'facility_name',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
