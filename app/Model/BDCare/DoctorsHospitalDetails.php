<?php

namespace App\Model\BDCare;

use App\Model\BDCare\Setup\Hospital;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DoctorsHospitalDetails extends Model
{
    protected $table = "doctors_hospital_details";
    protected $fillable = [
        'id',
        'doctor_id',
        'hospital_id',
        'f_time',
        's_time',
        'day',
        'created_by',
        'deleted_at',
        'updated_at'
    ];

    function get_hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    function get_doctor()
    {
        return $this->belongsTo(DoctorsData::class, 'doctor_id', 'created_by')->with('get_photo');
    }

    function get_user()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
