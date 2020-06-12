<?php

namespace App\Http\Controllers\BDCare;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Model\BDCare\PatientAppointmentDetails;

use DB;

class DoctorAppointmentBookedController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;
        $user_id = Auth::user()->id;

        if ($request->ajax()) {

            if($role_id == 1)
            {
                return PatientAppointmentDetails::with('get_patient')->with('get_doctor')->with('get_hospital')->orderBy('id', 'desc')->paginate($request->perPage);
               /* $query = DB::table('patient_appointment_details')
                    ->leftJoin('patient_datas', 'patient_appointment_details.patient_id', '=', 'patient_datas.id')
                    ->leftJoin('doctors_datas', 'patient_appointment_details.doctor_id', '=', 'doctors_datas.id')
                    ->whereNull('patient_appointment_details.deleted_at')
                    ->select(['patient_appointment_details.id AS id',
                        'patient_appointment_details.schedule',
                        'patient_appointment_details.day',
                        'patient_appointment_details.created_at',
                        'patient_datas.patient_name',
                        'patient_datas.gender',
                        'doctors_datas.doctor_name',
                    ]);

                return datatables()->of($query)->toJson();*/

            }
            else
            {
                //return PatientAppointmentDetails::with('get_patient')->with('get_doctor')->with('get_hospital')->where('doctor_id',$user_id)->orderBy('id', 'desc')->paginate($request->perPage);
                return PatientAppointmentDetails::with('get_patient')->with('get_doctor')->with('get_hospital')->where('doctor_id',$user_id)->orderBy('id', 'desc')->paginate($request->perPage);

                /*$query = DB::table('patient_appointment_details')
                    ->leftJoin('patient_datas', 'patient_appointment_details.patient_id', '=', 'patient_datas.id')
                    ->leftJoin('doctors_datas', 'patient_appointment_details.doctor_id', '=', 'doctors_datas.id')
                    ->where('patient_appointment_details.doctor_id',$user_id)
                    ->whereNull('patient_appointment_details.deleted_at')
                    ->select(['patient_appointment_details.id AS id',
                        'patient_appointment_details.schedule',
                        'patient_appointment_details.day',
                        'patient_appointment_details.created_at',
                        'patient_datas.patient_name',
                        'patient_datas.gender',
                        'doctors_datas.doctor_name',
                    ]);

                return datatables()->of($query)->toJson();*/
            }
        }

        return view('bdcare.doctors_booked_appointment');
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'doctor_name'   => 'required',
            'contact'       => 'required',
            'experience'    => 'required',
            'gender'        => 'required',
            'visiting_fees' => 'required',
            //'status'        => 'required',

            'details.*.speciality_id' => 'required',
            'degree_details.*.degree_id' => 'required',
            'degree_details.*.institute' => 'required',
            'hospital_details.*.hospital_id' => 'required',
            'hospital_details.*.f_time' => 'required',
            'hospital_details.*.s_time' => 'required',
            'hospital_details.*.day' => 'required',
        ], [
            'details.*.speciality_id.required' => 'Required field.',
            'degree_details.*.degree_id.required'  => 'Required field.',
            'degree_details.*.institute.required'  => 'Required field.',
            'hospital_details.*.hospital_id.required'=> 'Required field.',
            'hospital_details.*.f_time.required'=> 'Required field.',
            'hospital_details.*.s_time.required'=> 'Required field.',
            'hospital_details.*.day.required'=> 'Required field.',
        ]);

        $data = [
            'doctor_name'        => $request->doctor_name,
            'visiting_fees'      => $request->visiting_fees,
            'emergency_contact'  => $request->contact,
            'year_of_experience' => $request->experience,
            'gender'             => $request->gender,
            'address'            => $request->address,
            'summary'            => $request->summary,
            'status'             => $request->status,
            'created_by'         => Auth::user()->id,
        ];

        try {
            DB::beginTransaction();

            $result = PatientAppointmentDetails::create($data);
            $degree_details     = $this->dataFormat_degree($request, $result->id);
            $speciality_details = $this->dataFormat_speciality($request, $result->id);
            $hospital_details   = $this->dataFormat_hospital($request, $result->id);

            DoctorsDegreeDetails::insert($degree_details);
            DoctorsSpecialityDetails::insert($speciality_details);
            DoctorsHospitalDetails::insert($hospital_details);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Doctors Data successfully saved!']);
        } catch (\Exception $e) {
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
            $editModeData = PatientAppointmentDetails::FindOrFail($id);
            //print_r($editModeData);exit;
            $editModeDetailsDataDegree = DoctorsDegreeDetails::with('get_degree')->where('doctor_id',$id)->get();
            $editModeDetailsDataSpeciality = DoctorsSpecialityDetails::with('get_speciality')->where('doctor_id',$id)->get();
            $editModeDetailsDataHospital = DoctorsHospitalDetails::with('get_hospital')->where('doctor_id',$id)->get();

            $data = [
                'id'                    => $editModeData->id,
                'doctor_name'           => $editModeData->doctor_name,
                'visiting_fees'         => $editModeData->visiting_fees,
                'contact'               => $editModeData->emergency_contact,
                'gender'                => $editModeData->gender,
                'address'               => $editModeData->address,
                'experience'            => $editModeData->year_of_experience,
                'summary'               => $editModeData->summary,
                'status'                => $editModeData->status,
                'deleteID' => [],
                'deleteIDDegree' => [],
                'deleteIDHospital' => [],
                'degree_details'        => $editModeDetailsDataDegree,
                'details'               => $editModeDetailsDataSpeciality,
                'hospital_details'      => $editModeDetailsDataHospital
            ];
            return response()->json(['status'=>'success','data'=>$data]);
        } catch(\Exception $e){
            $message = $e->getMessage();
            return response()->json(['status'=>'error','data'=>[$message]]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'doctor_name'   => 'required',
            'contact'       => 'required',
            'experience'    => 'required',
            'gender'        => 'required',
            'visiting_fees' => 'required',
            //'status'        => 'required',

            'details.*.speciality_id' => 'required',
            'degree_details.*.degree_id' => 'required',
            'degree_details.*.institute' => 'required',
            'hospital_details.*.hospital_id' => 'required',
            'hospital_details.*.f_time' => 'required',
            'hospital_details.*.s_time' => 'required',
            'hospital_details.*.day' => 'required',
        ], [
            'details.*.speciality_id.required' => 'Required field.',
            'degree_details.*.degree_id.required'  => 'Required field.',
            'degree_details.*.institute.required'  => 'Required field.',
            'hospital_details.*.hospital_id.required'=> 'Required field.',
            'hospital_details.*.f_time.required'=> 'Required field.',
            'hospital_details.*.s_time.required'=> 'Required field.',
            'hospital_details.*.day.required'=> 'Required field.',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'doctor_name'        => $request->doctor_name,
                'visiting_fees'      => $request->visiting_fees,
                'emergency_contact'  => $request->contact,
                'year_of_experience' => $request->experience,
                'gender'             => $request->gender,
                'address'            => $request->address,
                'summary'            => $request->summary,
                'status'             => $request->status,
                'updated_by'         => Auth::user()->id,
            ];

            $editModeData = PatientAppointmentDetails::FindOrFail($id);
            $editModeData->update($data);

            /* Insert update and delete rm requisition details  */
            if (count($request->deleteID) > 0) {
                DoctorsSpecialityDetails::whereIn('speciality_id', $request->deleteID)->delete();
            }
            if (count($request->deleteIDDegree) > 0) {
                DoctorsDegreeDetails::whereIn('degree_id', $request->deleteIDDegree)->delete();
            }
            if (count($request->deleteIDHospital) > 0) {
                DoctorsHospitalDetails::whereIn('hospital_id', $request->deleteIDHospital)->delete();
            }

            $dataFormat = [];
            $count = count($request->details);
            for ($i = 0; $i < $count; $i++) {
                if (isset($request->details[$i]['id']) && $request->details[$i]['id'] !='') {
                    $updateData = [
                        'doctor_id'     => $id,
                        'speciality_id'     => $request->details[$i]['speciality_id'],
                        'remarks'         => $request->details[$i]['remarks'],
                    ];
                    DoctorsSpecialityDetails::where('id', $request->details[$i]['id'])->update($updateData);
                } else {
                    $dataFormat[$i] =[
                        'doctor_id'     => $id,
                        'speciality_id'     => $request->details[$i]['speciality_id'],
                        'remarks'         => $request->details[$i]['remarks'],
                    ];
                }
            }

            $dataFormatDegree = [];
            $count = count($request->degree_details);
            for ($i = 0; $i < $count; $i++) {
                if (isset($request->degree_details[$i]['id']) && $request->degree_details[$i]['id'] !='') {
                    $updateDataDegree = [
                        'doctor_id'     => $id,
                        'degree_id'     => $request->degree_details[$i]['degree_id'],
                        'institute'         => $request->degree_details[$i]['institute'],
                    ];
                    DoctorsDegreeDetails::where('id', $request->degree_details[$i]['id'])->update($updateDataDegree);
                } else {
                    $dataFormatDegree[$i] =[
                        'doctor_id'     => $id,
                        'degree_id'     => $request->degree_details[$i]['degree_id'],
                        'institute'         => $request->degree_details[$i]['institute'],
                    ];
                }
            }

            $dataFormatHospital = [];
            $count = count($request->hospital_details);
            for ($i = 0; $i < $count; $i++) {
                if (isset($request->hospital_details[$i]['id']) && $request->hospital_details[$i]['id'] !='') {
                    $updateDataHospital = [
                        'doctor_id'      => $id,
                        'hospital_id'    => $request->hospital_details[$i]['hospital_id'],
                        'f_time'         => date('H:i:s',strtotime($request->hospital_details[$i]['f_time'])),
                        's_time'         => date('H:i:s',strtotime($request->hospital_details[$i]['s_time'])),
                        'day'            => $request->hospital_details[$i]['day'],
                    ];
                    DoctorsHospitalDetails::where('id', $request->hospital_details[$i]['id'])->update($updateDataHospital);
                } else {
                    $dataFormatHospital[$i] =[
                        'doctor_id'      => $id,
                        'hospital_id'    => $request->hospital_details[$i]['hospital_id'],
                        'f_time'         => date('H:i:s',strtotime($request->hospital_details[$i]['f_time'])),
                        's_time'         => date('H:i:s',strtotime($request->hospital_details[$i]['s_time'])),
                        'day'            => $request->hospital_details[$i]['day'],
                    ];
                }
            }

            if(count($dataFormat) > 0){
                DoctorsSpecialityDetails::insert($dataFormat);
            }
            if(count($dataFormatDegree) > 0){
                DoctorsDegreeDetails::insert($dataFormatDegree);
            }
            if(count($dataFormatHospital) > 0){
                DoctorsHospitalDetails::insert($dataFormatHospital);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Doctors Data successfully updated!']);
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            //return response()->json(['status' => 'error', 'message' => 'Something Error Found !!!!!, Please try again']);
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function destroy($id)
    {
        try{

            DoctorsDegreeDetails::where('doctor_id',$id)->delete();
            DoctorsSpecialityDetails::where('doctor_id',$id)->delete();
            DoctorsHospitalDetails::where('doctor_id',$id)->delete();
            PatientAppointmentDetails ::FindOrFail($id)->delete();

            $bug = 0;
        }
        catch(\Exception $e){
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
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'doctor_id' => $id,
                'degree_id' => $request->degree_details[$i]['degree_id'],
                'institute' => $request->degree_details[$i]['institute']
            ];
        }
        return $dataFormat;
    }

    public function dataFormat_speciality($request, $id)
    {
        $dataFormat = [];
        $count = count($request->details);
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'doctor_id' => $id,
                'speciality_id' => $request->details[$i]['speciality_id'],
                'remarks' => $request->details[$i]['remarks']
            ];
        }
        return $dataFormat;
    }

    public function dataFormat_hospital($request, $id)
    {
        $dataFormat = [];
        $count = count($request->hospital_details);
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'doctor_id' => $id,
                'hospital_id' => $request->hospital_details[$i]['hospital_id'],
                'f_time' => date('H:i:s',strtotime($request->hospital_details[$i]['f_time'])),
                's_time' => date('H:i:s',strtotime($request->hospital_details[$i]['s_time'])),
                'day' => $request->hospital_details[$i]['day']
            ];
        }
        return $dataFormat;
    }

}
