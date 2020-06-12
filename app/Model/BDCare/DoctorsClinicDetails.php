<?php

namespace App\Model\BDCare;

use App\Model\BDCare\Setup\Area;
use App\Model\BDCare\Setup\City;
use Illuminate\Database\Eloquent\Model;


class DoctorsClinicDetails extends Model
{
    protected $table = "doctors_clinic_details";

    protected $fillable = [
        'id',
        'doctor_id',
        'clinic',
        'city',
        'area',
        'address',
        'contact',
        'f_time',
        's_time',
        'day',
        'created_by',
        'deleted_at',
        'updated_at'
    ];

    function get_doctor()
    {
        return $this->belongsTo(DoctorsData::class, 'doctor_id', 'created_by');
    }

    function get_city()
    {
        return $this->belongsTo(City::class, 'city');
    }

    function get_area()
    {
        return $this->belongsTo(Area::class, 'area');
    }
}
