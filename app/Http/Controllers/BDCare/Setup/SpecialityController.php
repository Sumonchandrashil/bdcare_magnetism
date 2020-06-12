<?php

namespace App\Http\Controllers\BDCare\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BDCare\Setup\speciality;
use Illuminate\Support\Facades\Auth;
use DB;

class SpecialityController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return datatables()->of(speciality::query())->toJson();
        }

        //return speciality::orderBy('speciality_name','asc')->paginate($request->perPage);

    }

    public function create()
    {
         return view('bdcare.setup.speciality');
    }

    public function store(Request $request)
    {   //dd($request);
        $this->validate($request, [
            'speciality_name'=>'required|unique:specialities,speciality_name',
            'status'=>'required',
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();
            speciality::create($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'speciality successfully saved !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'speciality is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return speciality::FindOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'speciality_name'=>'required',
            'status'=>'required',
        ]);

        $data = speciality::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();
            $data->update($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'speciality successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'speciality is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        $data = speciality::FindOrFail($id);
        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Speciality successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
