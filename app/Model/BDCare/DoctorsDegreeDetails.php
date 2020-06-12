<?php

namespace App\Model\BDCare;

use App\Model\BDCare\Setup\degree;
use Illuminate\Database\Eloquent\Model;

class DoctorsDegreeDetails extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;*/

    protected $table = "doctors_degree_details";

    protected $fillable = [
        'id',
        'doctor_id',
        'degree_id',
        'institute',
        'passing_year',
        'deleted_at',
        'updated_at'
    ];

    function get_degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }
}
