<?php

namespace App\Model\BDCare;

use App\Model\BDCare\Setup\Speciality;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DoctorsSpecialityDetails extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;*/

    protected $table = "doctors_speciality_details";

    protected $fillable = [
        'id',
        'doctor_id',
        'speciality_id',
        'remarks',
        'deleted_at',
        'updated_at'
    ];

    function get_speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

    function get_doctor()
    {
        return $this->belongsTo(DoctorsData::class, 'doctor_id', 'created_by');
    }

    function get_hospital()
    {
        return $this->belongsTo(DoctorsHospitalDetails::class, 'doctor_id', 'doctor_id');
    }

    function doctor_image()
    {
        return $this->belongsTo(User::class, 'doctor_id')->select('user_photo', 'id');
    }

    function get_user()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
}
