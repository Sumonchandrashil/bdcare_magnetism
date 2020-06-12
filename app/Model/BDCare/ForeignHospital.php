<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;

class ForeignHospital extends Model
{
    protected $table = "foreign_hospitals";

    protected $fillable = [
        'id',
        'country_id',
        'hospital_name',
        'address',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
