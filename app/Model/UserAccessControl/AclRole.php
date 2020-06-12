<?php

namespace App\Model\UserAccessControl;

use DB;
use Illuminate\Database\Eloquent\Model;

class AclRole extends Model
{
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    public $table = "acl_roles";

    protected $fillable = [
        'id',
        'role_name',
        'status',
        'created_by',
        'modified_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
