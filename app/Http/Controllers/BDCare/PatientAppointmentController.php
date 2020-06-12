<?php

namespace App\Http\Controllers\BDCare;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\Setup\degree;
use App\Model\BDCare\Setup\speciality;
use App\Model\BDCare\Setup\Hospital;
use App\Model\BDCare\Setup\City;
use App\Model\BDCare\Setup\Area;
use App\Model\BDCare\DoctorsDegreeDetails;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\DoctorsSpecialityDetails;

use DB;

class PatientAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $role_id = Auth::user()->role_id;
        $user_id = Auth::user()->id;

        if ($request->ajax()) {

            if($role_id == 1)
            {
                return PatientAppointmentDetails::with('get_doctor','get_patient','get_hospital')->orderBy('id', 'desc')->paginate($request->perPage);
            }
            else
            {
                return PatientAppointmentDetails::with('get_doctor','get_patient','get_hospital')->where('created_by',$user_id)->orderBy('id', 'desc')->paginate($request->perPage);
            }
        }

        $DegreeLists        = degree::get();
        $SpecialityLists    = speciality::get();
        $HospitalLists      = Hospital::get();
        $CityLists          = City::get();
        $AreaLists          = Area::get();
        $DayLists           = DB::table('days')->get();

        return view('bdcare.patient_appointment',compact('DegreeLists','SpecialityLists','HospitalLists','DayLists','CityLists','AreaLists'));
    }

    public function store(Request $request)
    {
       // dd($request);
        $this->validate($request, [

            'doctor'   => 'required',
            'hospital_details.*.book' => 'required|min:1',
        ], [
            'hospital_details.*.book.required'=> 'Select at least one.',
        ]);

        $data = [

            'patient_id'         => Auth::user()->id,
            'doctor_id'          => $request->doctor,
            'summary'            => $request->summary,

        ];

        try {
            DB::beginTransaction();


            $hospital_details   = $this->dataFormat_hospital($request);

            PatientAppointmentDetails::insert($hospital_details);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Doctors Data successfully saved!']);
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function get_hospital($city_id,$area_id)
    {
        if($area_id > 0 && $city_id > 0)
        {
            $HospitalList = Hospital::select('id','hospital_name')->where('city',$city_id)->where('area',$area_id)->get();
        }
        elseif($city_id > 0){
            $HospitalList = Hospital::select('id','hospital_name')->where('city',$city_id)->get();
        }
        elseif($area_id > 0){
            $HospitalList = Hospital::select('id','hospital_name')->where('area',$area_id)->get();
        }

        return $HospitalList;
    }

    public function get_doctor($hospital_id)
    {
        if($hospital_id > 0)
        {
            $doc_id = DoctorsHospitalDetails::select('doctor_id')->where('hospital_id',$hospital_id)->get();

            if($doc_id->count() > 0)
            {
                $DocList = DoctorsData::whereIn('id',$doc_id)->get();
            }
        }

        return $DocList;
    }

    function get_doctor_data($doctor_id)
    {
        if($doctor_id > 0)
        {
            $DoctorsDegreeDetails = DoctorsDegreeDetails::with('get_degree')->where('doctor_id',$doctor_id)->get();
            $DoctorsSpecialityDetails = DoctorsSpecialityDetails::with('get_speciality')->where('doctor_id',$doctor_id)->get();
            $DoctorsHospitalDetails = DoctorsHospitalDetails::with('get_hospital')->where('doctor_id',$doctor_id)->get();

            $data['DoctorsDegreeDetails']       = $DoctorsDegreeDetails;
            $data['DoctorsSpecialityDetails']   = $DoctorsSpecialityDetails;
            $data['DoctorsHospitalDetails']     = $DoctorsHospitalDetails;
            $hour_array = array();

            foreach ($DoctorsHospitalDetails as $doc_hospital_data)
            {
                $f_time = $doc_hospital_data->f_time;
                $s_time = $doc_hospital_data->s_time;

                $date1 = "1970-01-01 ".$f_time;
                $date2 = "1970-01-01 ".$s_time;

                $date1 = strtotime($date1);
                $date2 = strtotime($date2);

                // Formulate the Difference between two dates
                $diff = abs($date2 - $date1);

                // To get the year divide the resultant date into
                // total seconds in a year (365*60*60*24)
                $years = floor($diff / (365*60*60*24));

                // To get the month, subtract it with years and
                // divide the resultant date into
                // total seconds in a month (30*60*60*24)
                $months = floor(($diff - $years * 365*60*60*24)
                    / (30*60*60*24));

                // To get the day, subtract it with years and
                // months and divide the resultant date into
                // total seconds in a days (60*60*24)
                $days = floor(($diff - $years * 365*60*60*24 -
                        $months*30*60*60*24)/ (60*60*24));

                // To get the hour, subtract it with years,
                // months & seconds and divide the resultant
                // date into total seconds in a hours (60*60)
                $hours = floor(($diff - $years * 365*60*60*24
                        - $months*30*60*60*24 - $days*60*60*24)
                    / (60*60));

                // To get the minutes, subtract it with years,
                // months, seconds and hours and divide the
                // resultant date into total seconds i.e. 60
                $minutes = floor(($diff - $years * 365*60*60*24
                        - $months*30*60*60*24 - $days*60*60*24
                        - $hours*60*60)/ 60);

                // To get the minutes, subtract it with years,
                // months, seconds, hours and minutes

                $seconds = floor(($diff - $years * 365*60*60*24
                    - $months*30*60*60*24 - $days*60*60*24
                    - $hours*60*60 - $minutes*60));

                array_push($hour_array,($hours*2)+1);


            }

            $data['hour'] = $hour_array;

            return response()->json(['status'=>'success',
                                    'DoctorsDegreeDetails'=>$DoctorsDegreeDetails,
                                    'DoctorsSpecialityDetails'=>$DoctorsSpecialityDetails,
                                    'DoctorsHospitalDetails'=>$DoctorsHospitalDetails,
                                    'Hours'=>$data['hour']]);

            //return array($DoctorsDegreeDetails,$DoctorsSpecialityDetails);
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
                        'f_time'         => $request->hospital_details[$i]['f_time'],
                        's_time'         => $request->hospital_details[$i]['s_time'],
                        'day'            => $request->hospital_details[$i]['day'],
                    ];
                    DoctorsHospitalDetails::where('id', $request->hospital_details[$i]['id'])->update($updateDataHospital);
                } else {
                    $dataFormatHospital[$i] =[
                        'doctor_id'      => $id,
                        'hospital_id'    => $request->hospital_details[$i]['hospital_id'],
                        'f_time'         => $request->hospital_details[$i]['f_time'],
                        's_time'         => $request->hospital_details[$i]['s_time'],
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
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }

    public function destroy($id)
    {
        try{

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

    public function dataFormat_hospital($request)
    {
        print_r($request->hospital_details);exit;

        $dataFormat = [];

        $count = count($request->booking_details);

        for ($i = 0; $i < $count; $i++) {

            $dataFormat[$i] = [
                'patient_id'    => Auth::user()->id,
                'doctor_id'     => $request->doctor,
                'hospital_id'   => $request->booking_details[$i]['hospital_id'],
                'schedule'      => $request->booking_details[$i]['schedule'],
                'day'           => $request->booking_details[$i]['day'],
                'summary'       => $request->summary
            ];

        }
        return $dataFormat;
    }

}
