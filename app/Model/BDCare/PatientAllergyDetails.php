<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;


class PatientAllergyDetails extends Model
{
    protected $table = "patient_allergy_details";

    protected $fillable = [
        'id',
        'allergy_name',
        'remarks'
    ];
}
