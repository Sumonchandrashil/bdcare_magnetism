<?php

namespace App\Http\Controllers\BDCare;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BDCare\PatientMedication;
use Illuminate\Support\Facades\Auth;
use DB;

class PatientMedicationController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;
        $user_id = Auth::user()->id;

        if($role_id == 1)
        {
            //return PatientMedication::orderBy('id','desc')->paginate($request->perPage);
            return datatables()->of(PatientMedication::query())->toJson();
        }
        else
        {
            return datatables()->of(PatientMedication::query()->where('created_by',$user_id))->toJson();
            //return PatientMedication::where('created_by',$user_id)->orderBy('id', 'desc')->paginate($request->perPage);
        }


    }

    public function create()
    {
         return view('bdcare.patient_medication');
    }

    public function store(Request $request)
    {   //dd($request);
        $this->validate($request, [
            'status'=>'required',
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();
            PatientMedication::create($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'PatientMedication successfully saved !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'PatientMedication is Found Duplicate']);
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
        return PatientMedication::FindOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'medication_name'=>'required',
            'status'=>'required',
        ]);

        $data = PatientMedication::findOrFail($id);
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
            return response()->json(['status' => 'success', 'message' => 'Patient Medication successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'PatientMedication is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        $data = PatientMedication::FindOrFail($id);
        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'PatientMedication successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
