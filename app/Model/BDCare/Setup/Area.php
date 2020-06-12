<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $table = "areas";

    protected $fillable = [
        'id',
        'city',
        'area_name',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    function get_city()
    {
        return $this->belongsTo(City::class, 'city');
    }
}
