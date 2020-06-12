<?php

namespace App\Model\UserAccessControl;

use Illuminate\Database\Eloquent\Model;

class AclMenu extends Model
{
    public $table = "acl_menus";

    protected $fillable= [
        'id',
        'parent_id',
        'action',
        'menu_name',
        'menu_url',
        'module_id',
        'status',
        'created_at',
        'updated_at'
    ];
    //
}
