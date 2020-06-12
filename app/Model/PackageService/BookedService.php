<?php

namespace App\Model\PackageService;

use Illuminate\Database\Eloquent\Model;

class BookedService extends Model
{
    public $table = 'booked_services';

    protected $fillable = [
        'id',
        'service_id',
        'bookdate',
        'name',
        'number',
        'email',
        'age',
        'gender',
        'address',
        'status',
        'details',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];
}
