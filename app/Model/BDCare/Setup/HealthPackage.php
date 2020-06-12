<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class HealthPackage extends Model
{
    /*use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];*/
    protected $table = "health_packages";

    protected $fillable = ['id', 'package_name', 'location', 'description',
        'age_group', 'no_of_tests', 'price', 'discount', 'photo', 'status', 'created_by', 'updated_by'];
}
