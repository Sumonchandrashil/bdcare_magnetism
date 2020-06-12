<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;


class PatientSurgeryDetails extends Model
{
    protected $table = "patient_surgery_details";

    protected $fillable = [
        'id',
        'surgery_name',
        'remarks'
    ];
}
