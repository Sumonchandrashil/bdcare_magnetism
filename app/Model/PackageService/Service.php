<?php

namespace App\Model\PackageService;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /*use SoftDeletes;
    protected $softDelet = true;
    protected $dates = ['deleted_at'];*/
    public $table = 'services';

    protected $fillable = [
        'id',
        'name',
        'terms',
        'conditions',
        'details',
        'service_date',
        'hot_line_number',
        'image',
        'approve_status',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
