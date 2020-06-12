<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PackageBookedRequest;
use App\Http\Requests\Api\ServiceBookedRequest;
use App\Model\BDCare\DoctorsClinicDetails;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\DoctorsDegreeDetails;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\DoctorsSpecialityDetails;
use App\Model\BDCare\Notifications;
use App\Model\BDCare\OfferInfo;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\Setup\Area;
use App\Model\BDCare\Setup\City;
use App\Model\BDCare\Setup\degree;
use App\Model\BDCare\Setup\disease;
use App\Model\BDCare\Setup\facility;
use App\Model\BDCare\Setup\HealthPackage;
use App\Model\BDCare\Setup\Hospital;
use App\Model\BDCare\Setup\HospitalFacilityDetail;
use App\Model\BDCare\Setup\medicine;
use App\Model\BDCare\Setup\speciality;
use App\Model\PackageService\BookedPackage;
use App\Model\PackageService\BookedService;
use App\Model\PackageService\HelpCenter;
use App\Model\PackageService\Service;
use Carbon\Carbon;
use DB;
use Exception;
use FCM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use JWTFactory;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Validator;

class APIListController extends Controller
{
    public function __construct()
    {
        $this->appointment_schedule = appointment_schedule();
    }

    function degreeList(Request $request)
    {
        $DegreeList = degree::orderBy('degree_name', 'asc')->get();
        return response()->json(compact('DegreeList'));
    }

    function specialityList()
    {
        $SpecialityList = speciality::orderBy('speciality_name', 'asc')->get();
        return response()->json(compact('SpecialityList'));
    }

    function doctor_data()
    {
        $DocList = DoctorsData::orderBy('doctor_name', 'asc')->get();
        return response()->json(compact('DocList'));
    }

    function patient_data()
    {
        $PatientList = PatientData::orderBy('patient_name', 'asc')->get();
        return response()->json(compact('PatientList'));
    }

    function hospitalList()
    {
        $HospitalList = Hospital::orderBy('hospital_name', 'asc')->get();
        return response()->json(compact('HospitalList'));
    }

    function diseaseList()
    {
        $diseaseList = disease::orderBy('disease_name', 'asc')->get();
        return response()->json(compact('diseaseList'));
    }

    function facilityList()
    {
        $facilityList = facility::orderBy('facility_name', 'asc')->get();
        return response()->json(compact('facilityList'));
    }

    function HealthPackage()
    {
        $HealthPackage = HealthPackage::orderBy('id', 'desc')->get();
        return response()->json(compact('HealthPackage'));
    }

    function package_delete(Request $request)
    {
        try {
            DB::beginTransaction();

            BookedPackage::FindOrFail($request->id)->forceDelete();

            DB::commit();

            $data['status'] = true;
            $data['message'] = 'Success';
        } catch (Exception $e) {
            DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function service_delete(Request $request)
    {
        try {
            DB::beginTransaction();

            BookedService::FindOrFail($request->id)->forceDelete();

            DB::commit();

            $data['status'] = true;
            $data['message'] = 'Success';
        } catch (Exception $e) {
            DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function package_booked(PackageBookedRequest $request)
    {
        $user_id = Auth::user()->id;
        $datas = [
            'name' => $request->name,
            'number' => $request->number,
            'book_date' => $request->book_date,
            'email' => $request->email,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'package_id' => $request->package_id,
            'sample_collection' => $request->sample_collection,
            'status' => 0,
            'created_by' => $user_id,
        ];

        try {
            DB::beginTransaction();

            BookedPackage::insert($datas);

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function service_booked(ServiceBookedRequest $request)
    {
        $user_id = Auth::user()->id;

        $datas = [
            'service_id' => $request->service_id,
            'bookdate' => $request->book_date,
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'created_by' => $user_id,
            'created_at' => Carbon::now(),
        ];

        try {
            DB::beginTransaction();

            BookedService::insert($datas);

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function serviceList()
    {
        $ServiceList = Service::orderBy('id', 'asc')->get();
        return response()->json(compact('ServiceList'));
    }

    function DoctorHospitalList()
    {
        $DoctorHospitalList = DoctorsHospitalDetails::get();
        return response()->json(compact('DoctorHospitalList'));
    }

    function DoctorDegreeList(Request $request)
    {
        if (isset($request->degree)) {
            $DoctorDegreeList = DoctorsDegreeDetails::where('degree_id', $request->degree)->orderBy('id', 'asc')->get();
        } else {
            $DoctorDegreeList = DoctorsDegreeDetails::orderBy('id', 'asc')->get();
        }
        return response()->json(compact('DoctorDegreeList'));
    }

    function DoctorSpecialityList()
    {
        $DoctorSpecialityList = DoctorsSpecialityDetails::get();
        return response()->json(compact('DoctorSpecialityList'));
    }

    function HospitalFacilityList()
    {
        $HospitalFacilityList = HospitalFacilityDetail::get();//DB::table('hospital_facility_details')->get();
        return response()->json(compact('HospitalFacilityList'));
    }

    function cityList()
    {
        $cityList = City::get();//DB::table('hospital_facility_details')->get();
        return response()->json(compact('cityList'));
    }

    function AreaList(Request $request)
    {
        if (isset($request->city)) {
            $AreaList = Area::where('city', $request->city)->orderBy('area_name', 'ASC')->get();//DB::table('hospital_facility_details')->get();
        } else {
            $AreaList = Area::orderBy('area_name', 'ASC')->get();//DB::table('hospital_facility_details')->get();
        }
        return response()->json(compact('AreaList'));
    }

    function HospitalListByCityArea(Request $request)
    {
        if (isset($request->city)) {
            $hospitalList = Hospital::where('city', $request->city)->get();
        }

        if (isset($request->area)) {
            $hospitalList = Hospital::where('area', $request->area)->get();
        }

        if (isset($request->city) && isset($request->area)) {
            $hospitalList = Hospital::where('city', $request->city)->where('area', $request->area)->get();
        }

        return response()->json(compact('hospitalList'));
    }

    function DoctorListByHospital(Request $request)
    {
        $DocList = DoctorsHospitalDetails::with('get_doctor')->where('hospital_id', $request->hospital)->get();

        return response()->json($DocList);
        //return response()->json(compact('DocList'));
    }

    function DayListByDocHospital(Request $request)
    {
        /*echo $request->doctor_id;
        echo "<br>";
        echo $request->hospital_id;

        exit();*/

        if (isset($request->doctor_id)) {
            $dayList = DoctorsHospitalDetails::select('day')->where('doctor_id', $request->doctor_id)->groupBy('day')->get();
        }

        if (isset($request->hospital_id)) {   //echo $request->hospital_id;exit();
            $dayList = DoctorsHospitalDetails::select('doctor_id', 'day')->with('get_doctor')->where('hospital_id', $request->hospital_id)->groupBy('day')->get();
        }

        if (isset($request->doctor_id) && isset($request->hospital_id)) {
            $dayList = DoctorsHospitalDetails::select('day')->where('doctor_id', $request->doctor_id)->where('hospital_id', $request->hospital_id)->groupBy('day')->get();
        }

        return response()->json($dayList);
    }

    function ScheduleListByDocHospitalDay(Request $request)
    {
        $booked_time = array();

        $day_date = date('D', strtotime($request->day));

        $app_details = PatientAppointmentDetails::where('date', dateConvertFormtoDB($request->day))->where('hospital_id', $request->hospital_id)->where('doctor_id', $request->doctor_id)->get();

        if ($app_details->count() > 0) {
            foreach ($app_details as $app_schedule) {
                array_push($booked_time, $app_schedule->schedule);
            }
        }

        $scheduleListCount = DoctorsHospitalDetails::select('f_time', 's_time')->where('day', $day_date)->where('hospital_id', $request->hospital_id)->where('doctor_id', $request->doctor_id)->get();
        $scheduleList = DoctorsHospitalDetails::select('f_time', 's_time')->where('day', $day_date)->where('hospital_id', $request->hospital_id)->where('doctor_id', $request->doctor_id)->first();

        if ($scheduleListCount->count() == 0) {
            $blankararay = [];
            return response()->json($blankararay);
        }

        $f_time = $scheduleList->f_time;
        $s_time = $scheduleList->s_time;

        // Declare and define two dates
        $date1 = "1970-01-01 " . $f_time;
        $date2 = "1970-01-01 " . $s_time;

        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);

        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
        $years = floor($diff / (365 * 60 * 60 * 24));

        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365 * 60 * 60 * 24)
            / (30 * 60 * 60 * 24));

        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
            / (60 * 60));

        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
                - $hours * 60 * 60) / 60);

        // To get the minutes, subtract it with years,
        // months, seconds, hours and minutes

        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60 - $minutes * 60));

        $f_time = strtotime($f_time);

        $loop_length = ($hours * 4);

        $timeList = array();

        for ($i = 1; $i <= $loop_length; $i++) {

            if ($i == 1) {
                $start_time = date("H:i:s", strtotime('+0 minutes', $f_time));
                array_push($timeList, array('time' => $start_time));
            } else {
                $start_time = date("H:i:s", strtotime("+$this->appointment_schedule minutes", $f_time));
                $f_time = strtotime($start_time);
                array_push($timeList, array('time' => $start_time));
            }
        }

        $formatted_data = array();

        foreach ($timeList as $row) {

            $check = in_array($row['time'], $booked_time);

            if ($check) {
                $status = 1;
            } else {
                $status = 0;
            }
            $formatted_data[] = array(
                'time' => $row['time'],
                'booked_status' => $status,
            );
        }

        return response()->json($formatted_data);
    }

    function ScheduleListByDocClinicDate(Request $request)
    {
        $booked_time = array();

        $day_date = date('D', strtotime($request->day));

        $clinic = "0" . $request->clinic_id;

        $clinic_name = DoctorsClinicDetails::where('id', $request->clinic_id)->first()->clinic;

        $app_details = PatientAppointmentDetails::where('date', dateConvertFormtoDB($request->day))->where('hospital_id', $clinic)->where('doctor_id', $request->doctor_id)->get();

        if ($app_details->count() > 0) {
            foreach ($app_details as $app_schedule) {
                array_push($booked_time, $app_schedule->schedule);
            }
        }

        //$scheduleListCount = DoctorsClinicDetails::select('f_time','s_time')->where('day',$day_date)->where('id',$request->clinic_id)->where('doctor_id',$request->doctor_id)->get();
        $scheduleListCount = DoctorsClinicDetails::select('f_time', 's_time')->where('day', $day_date)->where('clinic', $clinic_name)->where('doctor_id', $request->doctor_id)->get();
        //$scheduleList = DoctorsClinicDetails::select('f_time','s_time')->where('day',$day_date)->where('id',$request->clinic_id)->where('doctor_id',$request->doctor_id)->first();
        $scheduleList = DoctorsClinicDetails::select('f_time', 's_time')->where('day', $day_date)->where('clinic', $clinic_name)->where('doctor_id', $request->doctor_id)->first();

        if ($scheduleListCount->count() == 0) {
            $blankararay = [];
            return response()->json($blankararay);
        }

        $f_time = $scheduleList->f_time;
        $s_time = $scheduleList->s_time;

        // Declare and define two dates
        $date1 = "1970-01-01 " . $f_time;
        $date2 = "1970-01-01 " . $s_time;

        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);

        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
        $years = floor($diff / (365 * 60 * 60 * 24));

        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365 * 60 * 60 * 24)
            / (30 * 60 * 60 * 24));

        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
            / (60 * 60));

        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
                - $hours * 60 * 60) / 60);

        // To get the minutes, subtract it with years,
        // months, seconds, hours and minutes

        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60 - $minutes * 60));

        $f_time = strtotime($f_time);

        $loop_length = ($hours * 4);

        $timeList = array();

        for ($i = 1; $i <= $loop_length; $i++) {

            if ($i == 1) {
                $start_time = date("H:i:s", strtotime('+0 minutes', $f_time));
                array_push($timeList, array('time' => $start_time));
            } else {
                $start_time = date("H:i:s", strtotime("+$this->appointment_schedule minutes", $f_time));
                $f_time = strtotime($start_time);
                array_push($timeList, array('time' => $start_time));
            }
        }
        //print_r($timeList);
        //print_r($booked_time);

        $formatted_data = array();

        foreach ($timeList as $row) {
            $check = in_array($row['time'], $booked_time);

            if ($check) {
                $status = 1;
            } else {
                $status = 0;
            }

            $formatted_data[] = array(
                'time' => $row['time'],
                'booked_status' => $status,
            );
        }

        //print_r($formatted_data);

        return response()->json($formatted_data);
        // return response()->json(compact('timeList'));
    }

    function HelpCenterDataInsert(Request $request)
    {
        try {
            $Helpdata = [

                'title' => $request->title,
                'entry_date' => date('Y-m-d'),
                'terms_condition' => $request->details,
                'email' => $request->email,

            ];

            DB::beginTransaction();

            HelpCenter::create($Helpdata);

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();

        } catch (Exception $e) {
            //$msg = $e->getMessage();
            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function medicineListNew(Request $request)
    {
        $string = $request->q;

        if ($string != '' && $string != ' ' && isset($string) && $string) {
            $medicineList = medicine::orderBy('medicine_name', 'ASC')->where('medicine_name', 'like', "%$string%")->limit(100)->get();
        } else {
            $medicineList = [];
        }

        return response()->json(compact('medicineList'));
    }

    function medicineList()
    {
        $medicineList = medicine::orderBy('medicine_name', 'ASC')->get();
        return response()->json(compact('medicineList'));
    }

    function questionList(Request $request)
    {
        $askList = HelpCenter::where('status', 2)
            ->orderBy('id', 'desc');

        if ($request->specialty) {
            $askList = $askList->where('terms_condition', 'LIKE', '%' . $request->specialty . '%');
        }

        $askList = $askList->get();
        return response()->json(compact('askList'));
    }

    function offerList()
    {
        $offerList = OfferInfo::where('status', 1)->orderBy('id', 'ASC')->get();
        return response()->json(compact('offerList'));
    }

    /*function push_notification()
    {
        $fcm_token =  ['d8FTrbC1Srkd8FTrbC1Srk:APA91bGgjyqE1fEX1hCsbxcC66oA0q7HfDX6ykgoFif43-0vgvfh9uTY0szvDNFtIrfZed0Zm3Es3pu1JyR-dag0YA5i8nIVwuR_NGQBF4_NFeKhz9v0BawboIIFfX49xTkM_AtlX8J_'];//$this->fcm_token;

        try{

            $req = fcm()
                ->to($fcm_token) // $recipients must an array
                ->priority('high')
                ->data([
                    'title' => 'Test FCM From Local Atiar',
                    'body' => 'This is a test of FCM... Atiar',
                ])
                ->notification([
                    'title' => 'Test FCM From Local Atiar',
                    'body' => 'This is a test of FCM... Atiar',
                ])
                ->send();
            print_r($req);
        }
        catch (\Exception $e)
        {
            $msg = $e->getMessage();
            print_r($msg);
        }
    }*/

    //Final Tested Notification

    function Noti()
    {
        $optionBuilder = new OptionsBuilder();
        //$optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('my title 1');
        $notificationBuilder->setBody('Hello world 1')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // $token = "a_registration_from_your_database";
        $token = "d8FTrbC1Srk:APA91bGgjyqE1fEX1hCsbxcC66oA0q7HfDX6ykgoFif43-0vgvfh9uTY0szvDNFtIrfZed0Zm3Es3pu1JyR-dag0YA5i8nIVwuR_NGQBF4_NFeKhz9v0BawboIIFfX49xTkM_AtlX8J_";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        //print_r( $downstreamResponse->numberSuccess() );
    }

    function notification_list(Request $request)
    {
        if ($request->role_id == 3) {
            $data = Notifications::where('created_for', $request->user_id)->orderBy('id', 'DESC')->get();
        } elseif ($request->role_id == 4) {
            $data = Notifications::where('created_for', $request->user_id)->orderBy('id', 'DESC')->get();
        }

        if ($data->count() > 0) {
            return response()->json(compact('data'));
        } else {
            $data = [];
            $data = (object)$data;
            return response()->json($data);
        }
    }

    function update_notification_status(Request $request)
    {
        $note_id = $request->id;

        try {
            $data = array(
                'status' => 1,
                'updated_by' => Auth::user()->id,
            );

            Notifications::where('id', $note_id)->update($data);

            $data['status'] = true;
            $data['message'] = 'Successfull';
        } catch (Exception $e) {
            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function HospitalDetails(Request $request)
    {
        $hospital = Hospital::with('get_facilities', 'get_images', 'doc_list')->where('id', $request->hospital_id)->first();

        if ($hospital) {
            $hospital = $hospital;
        } else {
            $hospital = [];
        }

        return response()->json(compact('hospital'));
    }

    function doctor_single_data(Request $request)
    {
        $data = DoctorsData::with('get_degree', 'get_photo', 'get_speciality', 'get_clinic', 'get_hospital')->where('created_by', $request->doc_id)->first();

        if ($data) {
            $data = $data;
        } else {
            $data = [];
        }

        return response()->json(compact('data'));
    }
}
