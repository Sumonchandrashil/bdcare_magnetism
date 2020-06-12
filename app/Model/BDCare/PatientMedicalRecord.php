<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;

class PatientMedicalRecord extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $table = "patient_medical_records";

    protected $fillable = [
        'id',
        'title',
        'image',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
