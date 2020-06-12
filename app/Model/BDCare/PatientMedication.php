<?php

namespace App\Model\BDCare;

use App\Model\BDCare\Setup\Medicine;
use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $table = "patient_medications";

    protected $fillable = [
        'id',
        'medication_name',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function get_medicine()
    {

        return $this->belongsTo(Medicine::class, 'medication_name', 'id');
    }
}
