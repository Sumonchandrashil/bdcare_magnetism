<?php

namespace App\Model\PackageService;

use Illuminate\Database\Eloquent\Model;

class HelpCenter extends Model
{
    /*use SoftDeletes;
    protected $softDelet = true;
    protected $dates = ['deleted_at'];*/

    public $table = 'help_centers';

    protected $fillable = [
        'id',
        'title',
        'entry_date',
        'terms_condition',
        'reply',
        'email',
        'status',
        'rating',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at'

    ];
}
