<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;


class PatientDiseaseDetails extends Model
{
    protected $table = "patient_disease_details";

    protected $fillable = [
        'id',
        'disease_id',
        'patient_id',
        'remarks',
        'updated_at',
        'deleted_at'
    ];
}
