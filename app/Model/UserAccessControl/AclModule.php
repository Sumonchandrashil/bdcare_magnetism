<?php

namespace App\Model\UserAccessControl;

use Illuminate\Database\Eloquent\Model;

class AclModule extends Model
{
    public $table = "acl_modules";

    protected $fillable=[
        'id',
        'module_name',
        'icon_class',
        'status',
        'created_at',
        'updated_at'
    ];
}
