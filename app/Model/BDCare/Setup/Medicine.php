<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class medicine extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $fillable = ['id','medicine_name','description','status','created_by','updated_by'];
}
