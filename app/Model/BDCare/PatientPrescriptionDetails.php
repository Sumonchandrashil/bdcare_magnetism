<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;

class PatientPrescriptionDetails extends Model
{
    protected $table = "patient_prescription_details";

    protected $fillable = [
        'id',
        'patient_id',
        'booking_id',
        'history',
        'diagonosis',
        'description',
        'rating',
        'recommendation',
        'tests',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by'
    ];


    public function get_patient()
    {

        return $this->belongsTo(PatientData::class, 'patient_id', 'created_by');
    }

    public function get_doctor()
    {

        return $this->belongsTo(DoctorsData::class, 'created_by', 'created_by');
    }

    public function get_appointment()
    {

        return $this->belongsTo(PatientAppointmentDetails::class, 'booking_id', 'doctor_id');
    }

    /*public function get_degrees()
    {
        return $this->belongsTo(DoctorsDegreeDetails::class,'doctor_id','created_by');
    }*/


}
