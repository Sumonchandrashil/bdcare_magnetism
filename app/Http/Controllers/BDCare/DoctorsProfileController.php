<?php

namespace App\Http\Controllers\BDCare;

use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\DoctorsDegreeDetails;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\DoctorsSpecialityDetails;
use App\Model\BDCare\Notifications;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DoctorsProfileController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;
        $user_id = Auth::user()->id;

        if ($request->ajax()) {
            if ($role_id == 1) {
                return datatables()->of(DoctorsData::query()->orderBy('id', 'desc'))->toJson();
                //return DoctorsData::orderBy('id', 'desc')->paginate($request->perPage);
            } else {
                return datatables()->of(DoctorsData::query()->where('created_by', $user_id))->toJson();
                //return DoctorsData::where('created_by',$user_id)->orderBy('id', 'desc')->paginate($request->perPage);
            }
        }

        /* $DegreeLists        = degree::get();
         $SpecialityLists    = speciality::get();
         $HospitalLists      = Hospital::get();
         $DayLists           = DB::table('days')->get();*/

        return view('bdcare.doctors_profile');
        // return view('bdcare.doctors_profile',compact('DegreeLists','SpecialityLists','HospitalLists','DayLists'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'doctor_name' => 'required',
            'contact' => 'required',
            'experience' => 'required',
            'gender' => 'required',
            'visiting_fees' => 'required',
            //'status'        => 'required',

            /*'details.*.speciality_id' => 'required',
            'degree_details.*.degree_id' => 'required',
            'degree_details.*.institute' => 'required',
            'hospital_details.*.hospital_id' => 'required',
            'hospital_details.*.f_time' => 'required',
            'hospital_details.*.s_time' => 'required',
            'hospital_details.*.day' => 'required',*/
        ]/*, [
            'details.*.speciality_id.required' => 'Required field.',
            'degree_details.*.degree_id.required'  => 'Required field.',
            'degree_details.*.institute.required'  => 'Required field.',
            'hospital_details.*.hospital_id.required'=> 'Required field.',
            'hospital_details.*.f_time.required'=> 'Required field.',
            'hospital_details.*.s_time.required'=> 'Required field.',
            'hospital_details.*.day.required'=> 'Required field.',
        ]*/);

        $data = [
            'doctor_name' => $request->doctor_name,
            'visiting_fees' => $request->visiting_fees,
            'emergency_contact' => $request->contact,
            'year_of_experience' => $request->experience,
            'gender' => $request->gender,
            'address' => $request->address,
            'summary' => $request->summary,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];

        try {
            DB::beginTransaction();

            $result = DoctorsData::create($data);
            /*$degree_details     = $this->dataFormat_degree($request, $result->id);
            $speciality_details = $this->dataFormat_speciality($request, $result->id);
            $hospital_details   = $this->dataFormat_hospital($request, $result->id);

            DoctorsDegreeDetails::insert($degree_details);
            DoctorsSpecialityDetails::insert($speciality_details);
            DoctorsHospitalDetails::insert($hospital_details);*/

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Doctors Data successfully saved!']);
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return response()->json(['status' => 'error', 'message' => 'Something Went wrong']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        try {
            $editModeData = DoctorsData::FindOrFail($id);
            $data = [
                'id' => $editModeData->id,
                'doctor_name' => $editModeData->doctor_name,
                'visiting_fees' => $editModeData->visiting_fees,
                'contact' => $editModeData->emergency_contact,
                'gender' => $editModeData->gender,
                'address' => $editModeData->address,
                'experience' => $editModeData->year_of_experience,
                'summary' => $editModeData->summary,
                'status' => $editModeData->status,
                'premium' => $editModeData->premium,
            ];

            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json(['status' => 'error', 'data' => [$message]]);
        }
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'doctor_name' => 'required',
            'contact' => 'required',
            'experience' => 'required',
            'gender' => 'required',
            'visiting_fees' => 'required',
            //'status'        => 'required',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'doctor_name' => $request->doctor_name,
                'visiting_fees' => $request->visiting_fees,
                'emergency_contact' => $request->contact,
                'year_of_experience' => $request->experience,
                'gender' => $request->gender,
                'address' => $request->address,
                'summary' => $request->summary,
                'status' => $request->status,
                'premium' => $request->premium,
                'updated_by' => Auth::user()->id,
            ];

            $editModeData = DoctorsData::FindOrFail($id);
            $editModeData->update($data);

            DB::commit();

            //Push Notification
            $dt = DoctorsData::where('id', $id)->first();
            $doctor = $dt->created_by;
            $status = $dt->status;

            $title = 'Account Activation';
            $msg = 'Dear Doctor ' . $request->doctor_name . ' your account is successfuly activated by doctor';
            $token = User::where('id', $doctor)->first() ? User::where('id', $doctor)->first()->token : '';//"d8FTrbC1Srk:APA91bGgjyqE1fEX1hCsbxcC66oA0q7HfDX6ykgoFif43-0vgvfh9uTY0szvDNFtIrfZed0Zm3Es3pu1JyR-dag0YA5i8nIVwuR_NGQBF4_NFeKhz9v0BawboIIFfX49xTkM_AtlX8J_";

            $data_not = array(

                'title' => $title,
                'details' => $msg,
                'key_note' => 'activation',
                'created_by' => Auth::user()->id,
                'created_for' => $doctor,
            );

            Notifications::insert($data_not);

            if ($status == 0 && $request->status == 1) {
                push_notification($title, $msg, $token);
            }

            return response()->json(['status' => 'success', 'message' => 'Doctors Data successfully updated!']);
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !!!!!, Please try again']);
            //return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function destroy($id)
    {
        try {

            DoctorsDegreeDetails::where('doctor_id', $id)->delete();
            DoctorsSpecialityDetails::where('doctor_id', $id)->delete();
            DoctorsHospitalDetails::where('doctor_id', $id)->delete();
            DoctorsData::FindOrFail($id)->delete();

            $bug = 0;
        } catch (Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Doctors Data successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table, can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function dataFormat_degree($request, $id)
    {
        $dataFormat = [];
        $count = count($request->degree_details);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $dataFormat[$i] = [
                    'doctor_id' => $id,
                    'degree_id' => $request->degree_details[$i]['degree_id'],
                    'institute' => $request->degree_details[$i]['institute']
                ];
            }
            return $dataFormat;
        }

    }

    public function dataFormat_speciality($request, $id)
    {
        $dataFormat = [];
        $count = count($request->details);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $dataFormat[$i] = [
                    'doctor_id' => $id,
                    'speciality_id' => $request->details[$i]['speciality_id'],
                    'remarks' => $request->details[$i]['remarks']
                ];
            }
            return $dataFormat;
        }

    }

    public function dataFormat_hospital($request, $id)
    {
        $dataFormat = [];
        $count = count($request->hospital_details);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $dataFormat[$i] = [
                    'doctor_id' => $id,
                    'hospital_id' => $request->hospital_details[$i]['hospital_id'],
                    'f_time' => date('H:i:s', strtotime($request->hospital_details[$i]['f_time'])),
                    's_time' => date('H:i:s', strtotime($request->hospital_details[$i]['s_time'])),
                    'day' => $request->hospital_details[$i]['day']
                ];
            }
            return $dataFormat;
        }

    }

}
