<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/
    protected $table = "disease";

    protected $fillable = [
        'id',
        'disease_name',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
}
