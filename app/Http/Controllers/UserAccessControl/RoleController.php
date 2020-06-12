<?php

namespace App\Http\Controllers\UserAccessControl;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\Model\UserAccessControl\AclRole;
use Auth;

class RoleController extends Controller
{

    public function index()
    {
        $role = AclRole::orderBy('id', 'desc')->get();
        return view('user_access_control.role.manage_role', compact('role'));
    }


    public function create()
    {
        return view('user_access_control.role.add_role');
    }


    public function store(RoleRequest $request)
    {

        $input=$request->all();
        $input['created_by'] = Auth::user()->id;
        $input['modified_by'] = Auth::user()->id;

        try{
            AclRole::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('role')->with('successMsg', 'Role Inserted Successfully');
        }elseif ($bug == 1062) {
            return redirect('role')->with('errorMsg', 'Role is Found Duplicate');
        } else {
            return redirect('role')->with('errorMsg', 'Something Error Found !, Please try again.');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $editModeData = AclRole::FindOrFail($id);
        return view('user_access_control.role.add_role',compact('editModeData'));
    }


    public function update(RoleRequest $request, $id)
    {
        $data = AclRole::findOrFail($id);
        $input=$request->all();
        $input['created_by'] = Auth::user()->id;
        $input['modified_by'] = Auth::user()->id;
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            return redirect('role')->with('successMsg', 'Role Updated Successfully');
        }elseif ($bug == 1062) {
            return redirect('role')->with('errorMsg', 'Role is Found Duplicate');
        } else {
            return redirect('role')->with('errorMsg', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id)
    {
        $data = AclRole::FindOrFail($id);

        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            echo "success";
        }else{
            echo 'error';
        }
    }
}
