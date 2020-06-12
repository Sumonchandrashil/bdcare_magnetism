<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class degree extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/

    protected $fillable = ['id','degree_name','description','status','created_by','updated_by'];
}
