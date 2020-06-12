<?php

namespace App\Http\Controllers\UserAccessControl;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\PatientData;
use App\Repositories\CommonRepositories;
use App\User;
use Auth;
use DB;
use Exception;
use Hash;
use PhpParser\Node\Expr\Cast\Object_;

class UserController extends Controller
{
    protected $commonRepositories;

    public function __construct(CommonRepositories $commonRepositories)
    {
        $this->commonRepositories = $commonRepositories;
    }

    public function index()
    {
        $role_id = Auth::user()->role_id;
        $user_id = Auth::user()->id;

        if ($role_id == 1) {
            //$userList = User::with('role')->orderBy('id', 'desc')->get();
            $userList = User::with('role')->orderBy('id', 'desc')->get();
        } else {
            //$userList = User::with('role')->where('id',$user_id)->orderBy('id', 'desc')->get();
            $userList = User::with('role')->where('id', $user_id)->orderBy('id', 'desc')->get();
        }

        return view('user_access_control.manage_user', compact('userList'));
    }

    public function create()
    {
        $roleList = $this->commonRepositories->selectRoleList();
        return view('user_access_control.add_user', compact('roleList'));
    }

    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $image = $request->file('user_photo');
        $input['created_by'] = Auth::user()->id;
        $input['modified_by'] = Auth::user()->id;

        if ($image) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('user_photo')) . '.' . $request->file('user_photo')->getClientOriginalExtension();

            $request->file('user_photo')->move('uploads/user_photo/', $imgName);
            $input['user_photo'] = $imgName;
        }

        try {
            User::create($input);
            $bug = 0;
        } catch (Exception $e) {
            $bug = $e->errorInfo[1];
        }
        if ($bug == 0) {
            return redirect('user')->with('successMsg', 'User Inserted Successfully.');
        } elseif ($bug == 1062) {
            return redirect('user')->with('errorMsg', 'User is Found Duplicate');
        } else {
            return redirect()->back()->with('errorMsg', 'Something Error Found !, Please try again.');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $editModeData = User::FindOrFail($id);
        $roleList = $this->commonRepositories->selectRoleList();
        return view('user_access_control.add_user', compact('editModeData', 'roleList'));
    }

    public function update(UserRequest $request, $id)
    {
        $data = User::findOrFail($id);
        //dd($data);
        $input = $request->all();

        if ($input['password'] == $input['password_confirmation'] && $input['password'] != '') {
            //dd($input['password'].'-'.$input['password_confirmation']);
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $data->password;
        }

        $image = $request->file('user_photo');
        $input['created_by'] = Auth::user()->id;
        $input['modified_by'] = Auth::user()->id;
        $input['status'] = isset($request->status) ? 1 : 0;

        if ($image) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('user_photo')) . '.' . $request->file('user_photo')->getClientOriginalExtension();

            $request->file('user_photo')->move('uploads/user_photo/', $imgName);
            if (file_exists('uploads/user_photo/' . $data->photo) AND !empty($data->photo)) {
                unlink('uploads/user_photo/' . $data->photo);
            }
            $input['user_photo'] = $imgName;
        }

        try {
            $data->update($input);
            $bug = 0;
        } catch (Exception $e) {
            $bug = $e->errorInfo[1];
        }
        if ($bug == 0) {
            return redirect('user')->with('successMsg', 'User Updated Successfully.');
        } elseif ($bug == 1062) {
            return redirect('user')->with('errorMsg', 'User is Found Duplicate');
        } else {
            return redirect()->back()->with('errorMsg', 'Something Error Found !, Please try again.');
        }
    }

    public function destroy($id)
    {
        $data = User::FindOrFail($id);
        if (file_exists('uploads/user_photo/' . $data->user_photo) AND !empty($data->user_photo)) {
            unlink('uploads/user_photo/' . $data->user_photo);
        }

        try {
            if ($data->role_id == 3) {
                $doctor_id = DB::table('doctors_datas')->where('created_by', '=', $data->id)->get()->first()->id;
                DoctorsData::FindOrFail($doctor_id)->delete();
            }
            if ($data->role_id == 4) {
                $patient_id = DB::table('patient_datas')->where('created_by', '=', $data->id)->get()->first()->id;
                PatientData::FindOrFail($patient_id)->delete();
            }

            $data->delete();
            $bug = 0;
        } catch (Exception $e) {
            $bug = $e->errorInfo[1];
            echo 'hasForeignKey';
        }

        if ($bug == 0) {
            echo "success";
        } else {
            echo 'error';
        }
    }
}
