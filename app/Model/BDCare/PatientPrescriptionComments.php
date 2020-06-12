<?php

namespace App\Model\BDCare;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PatientPrescriptionComments extends Model
{

    protected $table = "patient_prescription_comments";

    protected $fillable = [
        'id',
        'comment',
        'prescription_id',
        'created_at',
        'created_by'
    ];


    public function get_patient()
    {

        return $this->belongsTo(PatientData::class, 'created_by', 'created_by')->with('get_photo');
    }

    public function get_prescription()
    {

        return $this->belongsTo(PatientPrescriptionDetails::class, 'prescription_id', 'id');
    }

    public function get_photo()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'user_photo', 'user_name');
    }


}
