<?php

namespace App\Repositories;
use App\Model\UserAccessControl\AclRole;
use DB;

class CommonRepositories
{

    public  function selectRoleList(){
        $result = AclRole::get();
        $options = [''=>'---- Please select ----'];
        foreach ($result as $key => $value) {
            $options [$value->id] = $value->role_name;
        }
        return $options ;
    }

    public function all_menu(){
       $result = DB::table('menus')
           ->whereNotNull('menus.menu_url')
           ->whereNull('action')
           ->orderBy('module_id')
           ->orderBy('id')
           ->get();
       return $result;
    }
    public function all_sub_menus(){
        $result  = DB::table('menus')
            ->whereNotNull('action')
            ->get();
        return $result;
    }
    public function permission($role_id){
        $result = DB::table('menus')
            ->select(DB::raw('menus.id, menus.name, menus.menu_url, menus.parent_id, menus.module_id,menus_permission.menu_id'))
            ->join('menus_permission', 'menus_permission.menu_id', '=', 'menus.id')
            ->where('menus_permission.role_id', '=', $role_id)
            ->get();
        return $result;
    }
}
