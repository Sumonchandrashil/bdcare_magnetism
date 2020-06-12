<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;

class DoctorOffDaysDetails extends Model
{
    protected $table = "doctor_off_days_details";

    protected $fillable = [
        'id',
        'doctor_id',
        'doctor_off_day',
        'created_by',
        'updated_by',
        'updated_at'
    ];
}
