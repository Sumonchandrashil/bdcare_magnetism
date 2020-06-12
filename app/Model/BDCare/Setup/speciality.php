<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/
    protected $table = "specialities";

    protected $fillable = [
        'id',
        'speciality_name',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
