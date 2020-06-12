<?php

namespace App\Model\BDCare;

use App\User;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class PatientData extends Model
{
    /*protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $table = "patient_datas";

    protected $fillable = [
        'id',
        'patient_name',
        'email',
        'address',
        'contact',
        'gender',
        'age',
        'details',
        'occupation',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by'
    ];

    function get_photo()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'user_photo');
    }

    /*function get_book_date(){
        return $this->belongsTo(BookedService::class,'created_by','created_by');
    }*/
}
