<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class HospitalFacilityDetail extends Model
{

    public $timestamps = false;

    protected $table = "hospital_facility_details";
    protected $fillable = [
        'id',
        'hospital_id',
        'facility_id',
        'remarks'
    ];

    public function get_facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function get_hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

}
