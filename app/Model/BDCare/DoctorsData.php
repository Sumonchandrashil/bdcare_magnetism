<?php

namespace App\Model\BDCare;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DoctorsData extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $table = "doctors_datas";

    protected $fillable = [
        'id',
        'doctor_name',
        'visiting_fees',
        'messaging_fees',
        'emergency_contact',
        'email',
        'gender',
        'address',
        'bio_data',
        'current_designation',
        'year_of_experience',
        'bmdc_reg_no',
        'bmdc_reg_year',
        'bmdc_doc',
        'passport_nid',
        'rating',
        'status',
        'premium',
        'summary',
        'created_at',
        'updated_at',
        'created_by',
        'deleted_at',
        'updated_by',
        'online'
    ];

    function get_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    function get_photo()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'user_photo');
    }

    function get_speciality()
    {
        return $this->hasMany(DoctorsSpecialityDetails::class, 'doctor_id', 'created_by')->with('get_speciality');
    }

    function get_clinic()
    {
        return $this->hasMany(DoctorsClinicDetails::class, 'doctor_id', 'created_by')->with('get_city', 'get_area');
    }

    function get_hospital()
    {
        return $this->hasMany(DoctorsHospitalDetails::class, 'doctor_id', 'created_by')->with('get_hospital');
    }

    function get_degree()
    {
        return $this->hasMany(DoctorsDegreeDetails::class, 'doctor_id', 'created_by')->with('get_degree');
    }
}
