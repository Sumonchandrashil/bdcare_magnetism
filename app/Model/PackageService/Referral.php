<?php

namespace App\Model\PackageService;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public $table = 'referral';

    protected $fillable = [
        'id',
        'patient_name',
        'patient_age',
        'care_giver_name',
        'care_giver_age',
        'passport_no',
        'wheel_chair',
        'address',
        'mobile_number',
        'email',
        'date_of_travel',
        'foreign_hospital_id',
        'medical_report',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
