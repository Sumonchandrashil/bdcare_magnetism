<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    /* use SoftDeletes;
     protected $softDelete = true;*/
    protected $table = "days";

    protected $fillable = ['id', 'day','deleted_at'];
}
