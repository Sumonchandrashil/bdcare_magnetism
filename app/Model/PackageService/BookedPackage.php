<?php

namespace App\Model\PackageService;

use Illuminate\Database\Eloquent\Model;

class BookedPackage extends Model
{
    /*use SoftDeletes;
    protected $softDelet = true;
    protected $dates = ['deleted_at'];*/

    public $table = 'booked_packages';

    protected $fillable = [
        'id',
        'package_id',
        'book_date',
        'name',
        'address',
        'age',
        'gender',
        'number',
        'email',
        'sample_collection',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
