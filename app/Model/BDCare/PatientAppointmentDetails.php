<?php

namespace App\Model\BDCare;

use App\Model\BDCare\Setup\Hospital;
use Illuminate\Database\Eloquent\Model;

class PatientAppointmentDetails extends Model
{
    /*protected $softDelete = true;
    protected $dates = ['deleted_at'];*/
    protected $table = "patient_appointment_details";

    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'hospital_id',
        'schedule',
        'day',
        'date',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    function get_patient()
    {
        return $this->belongsTo(PatientData::class, 'patient_id', 'created_by');
    }

    function get_doctor()
    {
        return $this->belongsTo(DoctorsData::class, 'doctor_id', 'created_by');
    }

    function get_hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id')->with('get_areas', 'get_cities');
    }

    function get_clinic()
    {
        return $this->belongsTo(DoctorsClinicDetails::class, 'hospital_id')->with('get_area', 'get_city');
    }
}
