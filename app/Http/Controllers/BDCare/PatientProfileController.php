<?php

namespace App\Http\Controllers\BDCare;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\BDCare\Setup\disease;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\PatientAllergyDetails;
use App\Model\BDCare\PatientSurgeryDetails;
use App\Model\BDCare\PatientDiseaseDetails;


use DB;

class PatientProfileController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;
        $user_id = Auth::user()->id;

        if ($request->ajax()) {

            if($role_id == 1)
            {
                //return PatientData::orderBy('id','desc')->paginate($request->perPage);
                return datatables()->of(PatientData::query()->orderBy('id', 'desc'))->toJson();

            }
            else{
                return datatables()->of(PatientData::query()->where('created_by',$user_id))->toJson();
                //return PatientData::where('created_by',$user_id)->orderBy('id','desc')->paginate($request->perPage);
            }

        }

        $DiseaseList = [];//disease::get();

        return view('bdcare.patient_profile',compact('DiseaseList'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'patient_name'  => 'required',
            'contact'       => 'required',
            'email'         => 'required',
            'gender'        => 'required',

        ]);

        $data = [
            'patient_name'       => $request->patient_name,
            'email'              => $request->email,
            'contact'            => $request->contact,
            'gender'             => $request->gender,
            'address'            => $request->address,
            'details'            => $request->details,
            'occupation'         => $request->occupation,
            'status'             => $request->status,
            'created_by'         => Auth::user()->id,
        ];

        try {
            DB::beginTransaction();

            $result = PatientData::create($data);

            $disease_details    = $this->dataFormat_disease($request, $result->id);
            $surgery_details    = $this->dataFormat_surgery($request, $result->id);
            $allergy_details   = $this->dataFormat_allergy($request, $result->id);

            PatientDiseaseDetails::insert($disease_details);
            PatientSurgeryDetails::insert($surgery_details);
            PatientAllergyDetails::insert($allergy_details);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Patients Data successfully saved!']);

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        try {
            $editModeData = PatientData::FindOrFail($id);

            $editModeDetailsDataDisease = PatientDiseaseDetails::where('patient_id',$id)->get();
            $editModeDetailsDataSurgery = PatientSurgeryDetails::where('patient_id',$id)->get();
            $editModeDetailsDataAllergy =PatientAllergyDetails::where('patient_id',$id)->get();

            $data = [
                'id'                    => $editModeData->id,
                'patient_name'          => $editModeData->patient_name,
                'contact'               => $editModeData->contact,
                'gender'                => $editModeData->gender,
                'address'               => $editModeData->address,
                'email'                 => $editModeData->email,
                'details'               => $editModeData->details,
                'status'                => $editModeData->status,
                'occupation'            => $editModeData->occupation,
                'deleteIDDisease' => [],
                'deleteIDSurgery' => [],
                'deleteIDAllergy' => [],
                'disease_details'       => $editModeDetailsDataDisease,
                'surgery_details'       => $editModeDetailsDataSurgery,
                'allergy_details'       => $editModeDetailsDataAllergy
            ];
            return response()->json(['status'=>'success','data'=>$data]);
        } catch(Exception $e){
            $message = $e->getMessage();
            return response()->json(['status'=>'error','data'=>[$message]]);
        }
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $this->validate($request, [

            'patient_name'  => 'required',
            'contact'       => 'required',
            'email'         => 'required',
            'gender'        => 'required',

        ]);

        try {
            DB::beginTransaction();

            $data = [
                'patient_name'       => $request->patient_name,
                'email'              => $request->email,
                'contact'            => $request->contact,
                'gender'             => $request->gender,
                'address'            => $request->address,
                'details'            => $request->details,
                'status'             => $request->status,
                'occupation'         => $request->occupation,
                'updated_by'         => $user_id,
            ];

            $editModeData = PatientData::FindOrFail($id);
            $editModeData->update($data);

            /* Insert update and delete rm requisition details  */
            if (count($request->deleteIDDisease) > 0) {
                PatientDiseaseDetails::whereIn('disease_id', $request->deleteIDDisease)->delete();
            }
            if (count($request->deleteIDSurgery) > 0) {
                PatientSurgeryDetails::whereIn('id', $request->deleteIDSurgery)->delete();
            }
            if (count($request->deleteIDAllergy) > 0) {
                PatientAllergyDetails::whereIn('id', $request->deleteIDAllergy)->delete();
            }

            $dataFormat = [];
            $count = count($request->disease_details);
            for ($i = 0; $i < $count; $i++) {
                if (isset($request->disease_details[$i]['id']) && $request->disease_details[$i]['id'] !='') {
                    $updateData = [
                        'patient_id'     => $id,
                        'disease_id'     => $request->disease_details[$i]['disease_id'],
                        'remarks'         => $request->disease_details[$i]['remarks'],
                    ];
                    PatientDiseaseDetails::where('id', $request->disease_details[$i]['id'])->update($updateData);
                } else {
                    $dataFormat[$i] =[
                        'patient_id'     => $id,
                        'disease_id'     => $request->disease_details[$i]['disease_id'],
                        'remarks'         => $request->disease_details[$i]['remarks'],
                    ];
                }
            }

            $dataFormatSurgery = [];
            $count = count($request->surgery_details);
            for ($i = 0; $i < $count; $i++) {
                if (isset($request->surgery_details[$i]['id']) && $request->surgery_details[$i]['id'] !='') {
                    $updateDataSurgery = [
                        'patient_id'     => $id,
                        'surgery_name'     => $request->surgery_details[$i]['surgery_name'],
                        'remarks'         => $request->surgery_details[$i]['remarks'],
                    ];
                    PatientSurgeryDetails::where('id', $request->surgery_details[$i]['id'])->update($updateDataSurgery);
                } else {
                    $dataFormatSurgery[$i] =[
                        'patient_id'     => $id,
                        'surgery_name'     => $request->surgery_details[$i]['surgery_name'],
                        'remarks'         => $request->surgery_details[$i]['remarks'],
                    ];
                }
            }

            $dataFormatAllergy = [];
            $count = count($request->allergy_details);
            for ($i = 0; $i < $count; $i++) {
                if (isset($request->allergy_details[$i]['id']) && $request->allergy_details[$i]['id'] !='') {
                    $updateDataAllergy = [
                        'patient_id'      => $id,
                        'allergy_name'    => $request->allergy_details[$i]['allergy_name'],
                        'remarks'         => $request->allergy_details[$i]['remarks']
                    ];
                    PatientAllergyDetails::where('id', $request->allergy_details[$i]['id'])->update($updateDataAllergy);
                } else {
                    $dataFormatAllergy[$i] =[
                        'patient_id'      => $id,
                        'allergy_name'    => $request->allergy_details[$i]['allergy_name'],
                        'remarks'         => $request->allergy_details[$i]['remarks'],
                    ];
                }
            }

            if(count($dataFormat) > 0){
                PatientDiseaseDetails::insert($dataFormat);
            }
            if(count($dataFormatSurgery) > 0){
                PatientSurgeryDetails::insert($dataFormatSurgery);
            }
            if(count($dataFormatAllergy) > 0){
                PatientAllergyDetails::insert($dataFormatAllergy);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Patients Data successfully updated!']);
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function destroy($id)
    {
        try{
            PatientData::FindOrFail($id)->delete();

            $bug = 0;
        }
        catch(Exception $e){
            $bug = $e->errorInfo[1];
            $message = $e->getMessage();
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Patients Data successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table, can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function dataFormat_disease($request, $id)
    {
        $dataFormat = [];
        $count = count($request->disease_details);
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'patient_id' => $id,
                'disease_id' => $request->disease_details[$i]['disease_id'],
                'remarks' => $request->disease_details[$i]['remarks']
            ];
        }
        return $dataFormat;
    }

    public function dataFormat_surgery($request, $id)
    {
        $dataFormat = [];
        $count = count($request->surgery_details);
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'patient_id' => $id,
                'surgery_name' => $request->surgery_details[$i]['surgery_name'],
                'remarks' => $request->surgery_details[$i]['remarks']
            ];
        }
        return $dataFormat;
    }

    public function dataFormat_allergy($request, $id)
    {
        $dataFormat = [];
        $count = count($request->allergy_details);
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'patient_id' => $id,
                'allergy_name' => $request->allergy_details[$i]['allergy_name'],
                'remarks' => $request->allergy_details[$i]['remarks']
            ];
        }
        return $dataFormat;
    }
}
