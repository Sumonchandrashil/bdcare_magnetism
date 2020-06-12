<?php

namespace App\Model\UserAccessControl;

use Illuminate\Database\Eloquent\Model;

class AclMenuPermission extends Model
{
    public $table = "acl_menu_permissions";

    protected $fillable=[
        'id',
        'role_id',
        'menu_id',
        'created_by',
        'modified_by',
        'created_at',
        'updated_at'
    ];
}
