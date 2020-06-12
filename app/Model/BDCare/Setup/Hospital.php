<?php

namespace App\Model\BDCare\Setup;

use App\Model\BDCare\DoctorsHospitalDetails;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/
    protected $table = "hospitals";

    protected $fillable = [
        'id',
        'cover_image',
        'logo',
        'hospital_name',
        'motto',
        'help_line',
        'type',
        'excellence_center',
        'emergency_details',
        'web_address',
        'description',
        'email',
        'address',
        'area',
        'city',
        'country',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at'
    ];

    function get_areas()
    {
        return $this->belongsTo(Area::class, 'area');
    }

    function get_cities()
    {
        return $this->belongsTo(City::class, 'city');
    }

    function get_facilities()
    {
        return $this->hasMany(HospitalFacilityDetail::class, 'hospital_id')->with('get_facility');
    }

    function get_images()
    {
        return $this->hasMany(HospitalGalleryImage::class, 'hospital_id');
    }

    function doc_list()
    {
        return $this->hasMany(DoctorsHospitalDetails::class, 'hospital_id')->with('get_doctor');
    }

}
