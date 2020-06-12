<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorsClinicDetails;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\DoctorsSpecialityDetails;
use App\Model\BDCare\ForeignHospital;
use App\Model\BDCare\Notifications;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\PatientPrescriptionComments;
use App\Model\BDCare\Setup\Area;
use App\Model\BDCare\Setup\City;
use App\Model\BDCare\Setup\HealthPackage;
use App\Model\BDCare\Setup\Hospital;
use App\Model\BDCare\Setup\HospitalFacilityDetail;
use App\Model\BDCare\Setup\HospitalGalleryImage;
use App\Model\BDCare\Setup\Speciality;
use App\Model\BlogComment;
use App\Model\PackageService\BookedPackage;
use App\Model\PackageService\BookedService;
use App\Model\PackageService\HealthArticle;
use App\Model\PackageService\HelpCenter;
use App\Model\PackageService\Referral;
use App\Model\PackageService\Service;
use App\User;
use Carbon\Carbon;
use DB;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Session;

class FrontEndController extends Controller
{

    public function __construct()
    {
        $this->appointment_schedule = appointment_schedule();
    }

    public function index()
    {

        $data['hospital'] = Hospital::orderBy('hospital_name', 'ASC')->get();
        $data['city'] = City::orderBy('city_name', 'ASC')->get();
        $data['area'] = Area::orderBy('area_name', 'ASC')->get();
        $data['doctor'] = DoctorsData::get();
        $data['health_package'] = HealthPackage::orderBy('id', 'desc')->limit(3)->get();
        $data['health_service'] = Service::orderBy('id', 'desc')->limit(3)->get();
        $data['health_articles'] = HealthArticle::with('get_doctor')->orderBy('id', 'desc')->limit(3)->get();
        //dd( $data['health_articles']);

        return view('frontend.home', $data);
    }

    function contact_us()
    {
        return view('frontend.contact_us');
    }

    function about_us()
    {
        return view('frontend.about_us');

    }

    function book_appointment()
    {
        $data['hospital'] = Hospital::orderBy('hospital_name', 'ASC')->get();
        $data['city'] = City::where('status', 1)->orderBy('city_name', 'ASC')->get();
        $data['area'] = Area::where('status', 1)->orderBy('area_name', 'ASC')->get();
        $data['speciality'] = Speciality::orderBy('speciality_name', 'ASC')->get();
        $data['health_package'] = HealthPackage::orderBy('id', 'desc')->limit(3)->get();
        $data['health_service'] = Service::orderBy('id', 'desc')->limit(3)->get();

        return view('frontend.book_appointment', $data);
    }

    function search_doc_for_appointment(Request $request)
    {
        /*dd($request);*/

        $speciality = 0;
        $city = $request->city ? $request->city : 0;
        $area = $request->area ? $request->area : 0;

        return redirect("filter-doctor-data/$speciality/$city/$area");

        $city = $request->city;
        $area = $request->area;
        $speciality = $request->speciality;

        $doctors = DoctorsSpecialityDetails::select('doctor_id')->where('speciality_id', $speciality)->get();

        $doctor_id = ($doctors->toArray());

        $doctor_id = DoctorsData::select('created_by')->where('status', 1)->whereIn('created_by', $doctor_id)->orderBy('premium', 'DESC')->get()->toArray();

        $hospital_data = DoctorsHospitalDetails::select('hospital_id')->whereIn('doctor_id', $doctor_id)->get();

        $hospital_id = ($hospital_data->toArray());

        $hospital_filtered_id = Hospital::select('id')->whereIn('id', $hospital_id)->where('city', $city)->where('area', $area)->get();

        $hospital_filtered_id = ($hospital_filtered_id->toArray());

        $doctorClinicData = DoctorsClinicDetails::with('get_doctor')->where('city', $city)->where('area', $area)->paginate(10);
        $data['doc_Clinic_data'] = $doctorClinicData;//->toArray();
        $data['ClinicCount'] = count(DoctorsClinicDetails::with('get_doctor')->where('city', $city)->where('area', $area)->groupBy('clinic'));

        $filtered_doc_data = DoctorsHospitalDetails::with('get_doctor')->with('get_hospital')->whereIn('doctor_id', $doctor_id)->whereIn('hospital_id', $hospital_filtered_id)->groupBy('doctor_id')->paginate(10);

        $data['doc_data'] = $filtered_doc_data;//->toArray();
        $data['health_package'] = HealthPackage::orderBy('id', 'desc')->limit(3)->get();
        $data['city'] = City::orderBy('city_name', 'ASC')->get();
        $data['speciality'] = Speciality::orderBy('speciality_name', 'ASC')->get();
        $data['count'] = count($filtered_doc_data);
        $data['city_id'] = $city;
        $data['area_id'] = $area;

        return view('frontend.search_book_appointment', $data);
    }

    function searchDataDoctorUsingId($doctor_id)
    {
        $filtered_doc_data = DoctorsHospitalDetails::with('get_doctor')->with('get_hospital')->where('doctor_id', $doctor_id)->groupBy('doctor_id')->get();
        //print_r($filtered_doc_data);exit();
        $data['doc_data'] = $filtered_doc_data;//->toArray();
        $data['health_package'] = HealthPackage::orderBy('id', 'desc')->limit(3)->get();
        $data['city'] = City::orderBy('city_name', 'ASC')->get();
        $data['speciality'] = Speciality::orderBy('speciality_name', 'ASC')->get();
        $data['count'] = count($filtered_doc_data);
        return view('frontend.search_book_appointment', $data);
    }

    function booking($doc_id)
    {
        $data['doctor_data'] = DoctorsData::where('id', $doc_id)->get();
        $data['speciality'] = DoctorsSpecialityDetails::with('get_speciality')->where('doctor_id', $doc_id)->get();
        $schedules = DoctorsHospitalDetails::with('get_hospital')->where('doctor_id', $doc_id)->get();
        $data['schedules'] = $schedules;

        $data['f_time'] = $schedules->first()->f_time;
        $data['s_time'] = $schedules->first()->s_time;

        // Declare and define two dates
        $date1 = "1970-01-01 " . $data['f_time'];
        $date2 = "1970-01-01 " . $data['s_time'];

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

        $data['start_time'] = strtotime($schedules->first()->f_time);
        $data['end_time'] = strtotime($schedules->first()->s_time);

        $data['hours'] = $hours;
        $data['loop_counter'] = ($hours * 2) + 1;

        return view('frontend.appointment_booking', $data);
    }

    function search_appointment_data(Request $request)
    {
        //if($_POST['_token'] == 'uycNShtMvwOZ1GFeMx4wK6xZ3RAb6VMefcd7vuPA')


        $hospital = $request->hospital;
        $city = $request->city ? $request->city : 0;
        $area = $request->area ? $request->area : 0;

        return redirect("filter-doctor-data/$hospital/$city/$area?type=H");

        $hospital_data = Hospital::select('id')->where('city', $city)->where('area', $area)->get();
        $hospital_id = ($hospital_data->toArray());
        //print_r($hospital_id);exit;
        //Like query need to set
        $filtered_doc_data = DoctorsHospitalDetails::with('get_doctor')->with('get_hospital')->whereIn('hospital_id', $hospital_id)->groupBy('doctor_id')->get();

        $doctorClinicData = DoctorsClinicDetails::with('get_doctor')->where('city', $city)->where('area', $area)->get();

        $data['doc_data'] = $filtered_doc_data;//->toArray();
        $data['doc_Clinic_data'] = $doctorClinicData;//->toArray();

        $data['city'] = City::orderBy('city_name', 'ASC')->get();
        $data['speciality'] = Speciality::orderBy('speciality_name', 'ASC')->get();
        $data['health_package'] = HealthPackage::orderBy('id', 'desc')->get();
        $data['count'] = count($filtered_doc_data);
        $data['ClinicCount'] = count($doctorClinicData);

        $data['city_id'] = $city;
        $data['area_id'] = $area;
        return view('frontend.search_book_appointment', $data);
    }

    function more_packages()
    {
        $data['health_package'] = HealthPackage::orderBy('id', 'desc')->get();

        return view('frontend.health_packages', $data);
    }

    function emergency_health_service()
    {
        $data['health_service'] = Service::orderBy('id', 'desc')->get();

        return view('frontend.health_services', $data);
    }

    function patientReferral()
    {
        $foreignHospitals = ForeignHospital::join('countries', 'foreign_hospitals.country_id', '=', 'countries.id')
            ->where('status', 1)
            ->get();
        return view('frontend.patient_referral', compact('foreignHospitals'));
    }

    function referral_data(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = array_except($request->all(), ['_token', 'country_id']);

            if (Auth::user()) {
                $data['created_by'] = Auth::user()->id;
            }

            $medical_report = $request->file('medical_report');
            if ($medical_report) {
                $imgName = md5(str_random(30) . time() . '_' . $medical_report) . '.' . $medical_report->getClientOriginalExtension();
                $medical_report->move('uploads/medical_report/', $imgName);
                $data['medical_report'] = $imgName;
            }

            Referral::insert($data);

            DB::commit();
            $notification = array(
                'message' => 'Data save Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            $notification = array(
                'message' => 'Something Error Found !, Please try again.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    function hospitalList($city_id)
    {
        $data['hospital_list'] = Hospital::where('city', $city_id)->orderBy('hospital_name', 'ASC')->paginate(10);
        return view('frontend.hospitals_list', $data);
    }

    function GetDocNames(Request $request)
    {
        $url = url('/');

        if ($request->get('query')) {
            $query = $request->get('query');

            if ($request->type == "S") {
                $data = DB::table('specialities')
                    ->select('id', 'speciality_name')
                    ->where('speciality_name', 'LIKE', "%{$query}%")
                    ->where('status',1)
                    ->get();

                $output = '<div class="wrapper"><ul class="mat_list card scrollable">';
                foreach ($data as $row) {
                    $output .= '<li style="color: #0a0a0a"><a href="' . $url . '/filter-doctor-data/' . $row->id . '/' . $request->city . '/' . $request->area . '?type=S' . '">' . $row->speciality_name . '</a></li><br>';

                }
                $output .= '</ul></div>';
                echo $output;
            } elseif ($request->type == "H") {
                $data = DB::table('hospitals')
                    ->select('id', 'hospital_name')
                    ->where('hospital_name', 'LIKE', "%{$query}%")
                    ->where('area', $request->area)
                    ->where('city', $request->city)
                    ->orderBy('hospital_name', 'ASC')
                    ->get();


                $output = '<div class="wrapper"><ul class="mat_list card scrollable">';

                foreach ($data as $row) {
                    $output .= '<li style="color: #0a0a0a"><a href="' . $url . '/filter-doctor-data/' . $row->id . '/' . $request->city . '/' . $request->area . '?type=H' . '">' . $row->hospital_name . '</a></li><br>';

                }

                $output .= '</ul></div>';

                echo $output;
            } elseif ($request->type == "D") {
                $data = DB::table('doctors_datas')
                    ->select('id', 'doctor_name', 'created_by')
                    ->where('doctor_name', 'LIKE', "%{$query}%")
                    ->get();

                $output = '<div class="wrapper"><ul class="mat_list card scrollable">';
                foreach ($data as $row) {
                    $output .= '<li style="color: #0a0a0a"><a href="' . $url . '/filter-doctor-data/' . $row->created_by . '/' . $request->city . '/' . $request->area . '?type=D' . '">' . $row->doctor_name . '</a></li><br>';

                }
                $output .= '</ul></div>';
                echo $output;
            }


        }
    }

    function FilterDoctorDataForAppointment($speciality, $city, $area)
    {
        //$speciality this can be DOc , Hos, Spe

        if ($city == 0 || $area == 0 || $speciality == 0) {
            return redirect()->back()->with('message', 'Please Select City/Area/Type');
        }

        if ($city == 0) {
            $city = '';
        }
        if ($area == 0) {
            $area = '';
        }
        if ($speciality == 0) {
            $speciality = '';
        }

        if (isset($_GET['type']) && $_GET['type'] == 'D') {
            $doctor_id = $speciality;

            $doctor_id = DoctorsData::select('created_by')->where('status', 1)->where('created_by', $doctor_id)->orderBy('premium', 'DESC')->get()->toArray();

        } elseif (isset($_GET['type']) && $_GET['type'] == 'S') {
            $doctors = DoctorsSpecialityDetails::select('doctor_id')->where('speciality_id', $speciality)->get();

            $doctor_id = ($doctors->toArray());

            $doctor_id = DoctorsData::select('created_by')->where('status', 1)->whereIn('created_by', $doctor_id)->orderBy('premium', 'DESC')->get()->toArray();

        } elseif (isset($_GET['type']) && $_GET['type'] == 'H') {
            $hos_id = $speciality;
            $data['hospital_details'] = Hospital::where('id', $hos_id)->first();
            $data['hospital_gallery_data'] = HospitalGalleryImage::where('hospital_id', $hos_id)->limit(5)->get();
            $data['hospital_facility'] = HospitalFacilityDetail::with('get_facility')->where('hospital_id', $hos_id)->get();
            $data['doctor_data'] = DoctorsHospitalDetails::with('get_doctor', 'get_user')->where('hospital_id', $hos_id)->limit(5)->groupBy('doctor_id')->get();
            $data['all_doctors'] = DoctorsHospitalDetails::with('get_doctor')->where('hospital_id', $hos_id)->groupBy('doctor_id')->get();
            $data['city_id'] = $city;
            $data['area_id'] = $area;

            return view('frontend.hospital_detail', $data);
        }

        $hospital_data = DoctorsHospitalDetails::select('hospital_id')->whereIn('doctor_id', $doctor_id)->get();

        /*dd($hospital_data);*/

        $hospital_id = ($hospital_data->toArray());


        if ($city == '' && $area != '') {
            $doctorClinicData = DoctorsClinicDetails::with('get_doctor')->whereIn('doctor_id', $doctor_id)->where('area', $area)->get();
            $hospital_filtered_id = Hospital::select('id')->whereIn('id', $hospital_id)->where('area', $area)->get();
        } elseif ($city != '' && $area == '') {
            $doctorClinicData = DoctorsClinicDetails::with('get_doctor')->whereIn('doctor_id', $doctor_id)->where('city', $city)->get();
            $hospital_filtered_id = Hospital::select('id')->whereIn('id', $hospital_id)->where('city', $city)->get();
        } elseif ($city == '' && $area == '') {
            $doctorClinicData = DoctorsClinicDetails::with('get_doctor')->whereIn('doctor_id', $doctor_id)->get();
            $hospital_filtered_id = Hospital::select('id')->whereIn('id', $hospital_id)->get();
        } elseif ($city != '' && $area != '') {
            $doctorClinicData = DoctorsClinicDetails::with('get_doctor')->whereIn('doctor_id', $doctor_id)->where('city', $city)->where('area', $area)->get();
            $hospital_filtered_id = Hospital::select('id')->whereIn('id', $hospital_id)->where('area', $area)->where('city', $city)->get();
        }

        $hospital_filtered_id = ($hospital_filtered_id->toArray());

        $filtered_doc_data = DoctorsHospitalDetails::with('get_doctor')->with('get_hospital')->whereIn('doctor_id', $doctor_id)->whereIn('hospital_id', $hospital_filtered_id)->groupBy('doctor_id')->get();

        $data['doc_data'] = $filtered_doc_data;//->toArray();

        $data['health_package'] = HealthPackage::orderBy('id', 'desc')->limit(3)->get();
        $data['city'] = City::get();
        $data['speciality'] = Speciality::get();
        $data['count'] = count($filtered_doc_data);
        $data['doc_Clinic_data'] = $doctorClinicData;
        $data['ClinicCount'] = count($doctorClinicData);
        $data['speciality_id'] = $speciality;
        $data['city_id'] = $city;
        $data['area_id'] = $area;

        $db_data = PatientPrescriptionComments::whereIn('doctor_id', $doctor_id)
            ->groupBy('doctor_id')
            ->select(DB::raw('AVG(rating) as average_rating'), DB::raw('count(id) as counter'))->first();
        if ($db_data != null) {
            $data['rating'] = $db_data->average_rating;
            $data['count'] = $db_data->counter;
        } else {
            $data['rating'] = 0;
            $data['count'] = 0;
        }

        return view('frontend.search_book_appointment', $data);
    }

    function blogs()
    {
        $data['articles'] = HealthArticle::with('get_doctor')->orderBy('id', 'DESC')->paginate(5);
        return view('frontend.blog_list', $data);
    }

    function blog_single($article_id)
    {
        $data['articles'] = HealthArticle::with('get_doctor')->where('id', $article_id)->first();
        //dd($data['articles']);

        $data['comments'] = BlogComment::where(['blog_id' => $article_id, 'parent_id' => 0])->with('replies')->get();

        //$data['health_articles'] = HealthArticle::with('get_doctor')->orderBy('id', 'desc')->limit(3)->get();

        return view('frontend.single_blog', $data);
    }

    function blogFiltering(Request $request)
    {

        if (isset($request->filter_value)) {

            $filterValue = $request->filter_value;

            $query = HealthArticle::select('*');
            $query->orderBy('health_articles.id', 'desc');

            if ($filterValue) {
                $query->where('health_articles.title', 'like', '%' . $filterValue . '%');
            }

            $data['articles'] = $query->paginate('5');

            return view('frontend.blog_list', $data);

        }
    }

    function addBlogComment(Request $request)
    {

        $data = [
            'comment' => $request->comment,
            'blog_id' => $request->blog_id,
            'parent_id' => 0,
            'created_by' => Auth::user()->id,

        ];

        try {
            BlogComment::create($data);
            return redirect(url('blog_single/' . $request->blog_id))->with('successMsg', 'Successfully send.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect(url('blog_single/' . $request->blog_id))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function getBlogComment()
    {
        $blogCommentByUser = BlogComment::where('created_by', Auth::user()->id)->get();
        return view('frontend.single_blog', $blogCommentByUser);
    }

    function replyBlogComment(Request $request)
    {

        $data = [
            'comment' => $request->comment,
            'blog_id' => $request->parent_id,
            'parent_id' => $request->blog_id,
            'created_by' => Auth::user()->id,


        ];

        try {
            BlogComment::create($data);
            return redirect('blog_single/' . $request->parent_id)->with('successMsg', 'Successfully send.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect(url('blog_single/' . $request->parent_id))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function ask_docor()
    {
        $specialistData = Speciality::where('status', 1)->get();
        $askList = HelpCenter::where('status', 2)->orderBy('id', 'desc')->paginate(10);
        return view('frontend.ask_docor', compact('specialistData', 'askList'));
    }

    function package_details($package_id)
    {
        $data['package_id'] = $package_id;
        $data['health_package'] = HealthPackage::Find($package_id);
        $data['package_name'] = HealthPackage::Find($package_id)->package_name;
        $data['related_health_package'] = HealthPackage::where('package_name', 'like', $data['package_name'])->where('id', '!=', $data['package_id'])->limit(3)->get();

        return view('frontend.package_details', $data);
    }

    function foreignHospitals()
    {
        $countries = ForeignHospital::query()
            ->join('countries', 'foreign_hospitals.country_id', '=', 'countries.id')
            ->select('countries.id', 'countries.country_name')
            ->distinct()
            ->get();
        return view('frontend.foreign_hospitals', compact('countries'));
    }

    function getForeignHospitals(Request $request)
    {
        $hospitals = ForeignHospital::where('country_id', '=', $request->country_id)
            ->get();

        return response()->json($hospitals);
    }

    function onlineConsult()
    {
        return view('frontend.online_consult');
    }

    function service_details($id)
    {
        $data['Service'] = Service::where('id', $id)->first();

        $data['service_id'] = $id;

        if (Auth::user()) {

            $user = Auth::user()->id;

            $role_id = User::where('id', $user)->first()->role_id;

            if ($role_id == 4) {
                $data['user_data'] = PatientData::select('patient_name as name', 'contact as number', 'email', 'address', 'gender', 'age')/*->with('get_book_date')*/ ->where('created_by', $user)->first();

            } elseif ($role_id == 3) {
                $data['user_data'] = DoctorsData::select('doctor_name as name', 'emergency_contact as number', 'email', 'address', 'gender', 'age')->where('created_by', $user)->first();
            } else {
                $data['user_data'] = '';
            }

        } else {
            $data['user_data'] = '';
        }

        return view('frontend.service', $data);
//        return redirect()->back()->with('frontend.service', $data);
    }


    function ask_doctor(Request $request)
    {

        //dd($request->Symptom);
        $symp = '';

        for ($i = 0; $i < count($request->Symptom); $i++) {
            $symp .= $request->Symptom[$i] . ',';

        }
        $symp_all = rtrim($symp, ',');

        $data = [
            'title' => $request->title,
            'email' => $request->email,
            'terms_condition' => $symp_all,
            'entry_date' => date('Y-m-d'),
            'status' => 2,
        ];

        try {

            $exists = HelpCenter::create($data);

            return redirect(url('ask-doctor'))->withInput()->with('successMsg', 'Data Successfully Sent.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect(url('ask-doctor'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }


    }

    function app_booking($doctor_id, $hospital_id, $day, $start_time, $id4, $id5, $id6)
    {
        if (!Auth::check()) {

            $prev_url = url()->current();

            Session::put('prev_url', $prev_url);

            return redirect(url('admin-login'))->withInput()->with('errorMsg', 'Please Login to Book Appointment');

        } else {

            $date = $id5 . '/' . $id4 . '/' . $id6;

            $schedule = date('H:i:s', strtotime($start_time));

            $data = array(

                'patient_id' => Auth::user()->id,
                'doctor_id' => $doctor_id,
                'hospital_id' => $hospital_id,
                'schedule' => $schedule,
                'day' => $day,
                'date' => dateConvertFormtoDB($date),
                'created_by' => Auth::user()->id,
                'created_at' => dateConvertFormtoDB(date('Y-m-d H:i:s')),//date('Y-m-d H:i:s')
            );

            $check_appointment = PatientAppointmentDetails::where('doctor_id', $doctor_id)->where('hospital_id', $hospital_id)->where('schedule', $schedule)->where('day', $day)->where('date', dateConvertFormtoDB($date))->count();

            if ($check_appointment > 0) {
                $message = 'Schedule Already Booked Please Select Another Schedule';
                return redirect(url('appointment-booking'))->withInput()->with('errorMsg', $message);
            }

            try {
                DB::beginTransaction();

                PatientAppointmentDetails::insert($data);

                DB::commit();

                $doctor_name = DoctorsData::where('created_by', $doctor_id)->first() ? DoctorsData::where('created_by', $doctor_id)->first()->doctor_name : '';
                $patient_name = PatientData::where('created_by', Auth::user()->id)->first() ? PatientData::where('created_by', Auth::user()->id)->first()->patient_name : '';
                $hospital_name = Hospital::where('id', $hospital_id)->first() ? Hospital::where('id', $hospital_id)->first()->hospital_name : '';
                $time = date("d-M-y", strtotime($date)) . '>' . date('H:i:s A', strtotime($schedule));
                $msg = 'Dear Doctor ' . $doctor_name . ' one patient named ' . $patient_name . ' want to have a booking at ' . $hospital_name . ' on ' . $time;
                $token = User::where('id', $doctor_id)->first() ? User::where('id', $doctor_id)->first()->token : '';//"d8FTrbC1Srk:APA91bGgjyqE1fEX1hCsbxcC66oA0q7HfDX6ykgoFif43-0vgvfh9uTY0szvDNFtIrfZed0Zm3Es3pu1JyR-dag0YA5i8nIVwuR_NGQBF4_NFeKhz9v0BawboIIFfX49xTkM_AtlX8J_";
                $title = "Booking Request";

                $data_not = array(
                    'title' => $title,
                    'details' => $msg,
                    'key_note' => 'appointment',
                    'created_at' => Carbon::now(),
                    'created_by' => Auth::user()->id,
                    'created_for' => $doctor_id,
                );

                Notifications::insert($data_not);

                if ($token != '') {
                    push_notification($title, $msg, $token);
                }

                return redirect(url('appointment-booking'))->withInput()->with('successMsg', 'Thaks! Your order is successfully submitted. We’ll get back you soon over phone.');
            } catch (Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                return redirect(url('appointment-booking'))->withInput()->with('errorMsg', 'Something Went Wrong');
            }
        }
    }

    function clinic_app_booking($doctor_id, $hospital_id, $day, $start_time, $month, $days, $year)//$hospital_id is actualy clinic id
    {
        $date = $days . '/' . $month . '/' . $year;

        if (!Auth::check()) {

            $prev_url = url()->current();
            //exit();
            Session::put('prev_url', $prev_url);

            return redirect(url('admin-login'))->withInput()->with('errorMsg', 'Please Login to Book Appointment');

        } else {

            $schedule = date('H:i:s', strtotime($start_time));

            $data = array(

                'patient_id' => Auth::user()->id,
                'doctor_id' => $doctor_id,
                'hospital_id' => $hospital_id,
                'schedule' => $schedule,
                'day' => $day,
                'date' => dateConvertFormtoDB($date),
                'created_by' => Auth::user()->id,
                'created_at' => dateConvertDBtoForm(date('Y-m-d H:i:s')),//date('Y-m-d H:i:s')
            );

            $check_appointment = PatientAppointmentDetails::where('doctor_id', $doctor_id)->where('hospital_id', $hospital_id)->where('schedule', $schedule)->where('day', $day)->where('date', dateConvertFormtoDB($date))->count();

            if ($check_appointment > 0) {
                $message = 'Schedule Already Booked Please Select Another Schedule';
                return redirect(url('appointment-booking'))->withInput()->with('errorMsg', $message);
            } else {
                try {
                    DB::beginTransaction();

                    PatientAppointmentDetails::insert($data);

                    DB::commit();
                    return redirect(url('appointment-booking'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
                } catch (Exception $e) {
                    DB::rollback();
                    $message = $e->getMessage();
                    return redirect(url('appointment-booking'))->withInput()->with('errorMsg', 'Something Went Wrong');
                }
            }


        }
    }

    function terms_condition()
    {
        return view('frontend.terms_condition');
    }

    function privacy_policy()
    {
        return view('frontend.privacy_policy');
    }

    function package_booking($package_id)
    {
        $data['package_id'] = $package_id;
        $data['health_package'] = HealthPackage::Find($package_id);

        return view('frontend.package_booking', $data);
    }

    function submit_package(Request $request)
    {
        if (Auth::user()) {
            $us_id = Auth::user()->id;
        } else {
            $us_id = 0;
        }

        $data = [
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
            'created_by' => $us_id,
        ];

        try {
            DB::beginTransaction();

            BookedPackage::insert($data);

            DB::commit();
            return redirect(url('package_booking' . '/' . $request->package_id))->withInput()->with('successMsg', 'Thanks! Your order is successfully submitted. We’ll get back you soon over phone.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('package_booking' . '/' . $request->package_id))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function submit_service(Request $request)
    {
        if (Auth::user()) {
            $us_id = Auth::user()->id;
        } else {
            $us_id = 0;
        }

        $data = [
            'bookdate' => dateConvertFormtoDB($request->bookdate),
            'name' => $request->name,
            'number' => $request->number,
            'email' => $request->email,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'service_id' => $request->service_id,
            'status' => 0,
            'created_by' => $us_id,
        ];

        try {
            DB::beginTransaction();

            BookedService::insert($data);

            DB::commit();
            return redirect(url('service_details' . '/' . $request->service_id))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('service_details' . '/' . $request->service_id))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function get_areas(Request $request)
    {
        $data = Area::where('city', $request->city)->orderBy('area_name', 'asc')->get();

        foreach ($data as $area_data) {
            ?>

            <option value="<?= $area_data->id; ?>"><?= $area_data->area_name; ?></option>

            <?php
        }

    }

    function get_hospital_list(Request $request)
    {
        $data = Hospital::where('city', $request->city)->where('area', $request->area)->orderBy('hospital_name', 'asc')->get();

        foreach ($data as $hospital_data) {
            ?>

            <option value="<?= $hospital_data->id; ?>"><?= $hospital_data->hospital_name; ?></option>

            <?php
        }

    }

    function forget_pass()
    {
        return view('forget_pass');
    }

    function otp_login()
    {
        return view('otp_login');
    }

    function password_forgeting(Request $request)
    {
        //$email = $request->email;
        $mobile = $request->mobile;

        //$data_status = User::where('mobile', $mobile)->where('email', $email)->get();
        $data_status = User::where('mobile', $mobile)->get();

        $pass = rand(100000, 500000);

        if ($data_status->count() > 0) {
            $headers = "From: info@bd.care" . "\r\n" .

                $msg = "Your new password is : $pass";

            $sub = 'Password Recovery';

            $password['password'] = Hash::make($pass);

            //User::where('mobile', $mobile)->where('email', $email)->update($password);
            User::where('mobile', $mobile)->update($password);

            //mail($email, $sub, $msg, $headers);

            //OTP Send

            $client = new Client();
            $response = $client->request('GET', "http://sms.bulksmsroute.com/smsapi?api_key=R60005625cb5ac9cbcdfc0.73859382&type=text&contacts=$mobile&senderid=BDCARE&msg=$msg");

            # Send an asynchronous request.
            $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
            $promise = $client->sendAsync($request)->then(function ($response) {
                //echo 'I completed! ' . $response->getBody();
                return 'TRUE';
            });

            $promise->wait();

            Session::put('forget_pass_mobile_otp_login', $mobile);

            return redirect(url('otp_login'))->withInput()->with('successMsg', 'You will get an otp soon. check msg & login');
        } else {

            return redirect(url('forget_pass'))->withInput()->with('errorMsg', 'Inserted Data not Matched. Please try again or contact to admin');
        }
    }

    function getShedule(Request $request)
    {
        $T = $request->T;
        $date = date('Y-m-d', strtotime($request->date));
        $day = date('D', strtotime($request->date));
        $hospital = $request->hospital;
        $doctor = $request->doctor;

        $doc_data = DoctorsHospitalDetails::select('f_time', 's_time', 'day')->where('day', $day)->where('hospital_id', $hospital)->where('doctor_id', $doctor)->get();

        //Previous Appointment
        $hospital_array = [];

        array_push($hospital_array, $hospital);

        $previous_appointment_data = PatientAppointmentDetails::where('date', $date)->where('day', $day)->whereIn('hospital_id', $hospital_array)->pluck('schedule')->toArray();

        //End

        if ($doc_data->count() > 0) {
            $f_time = $doc_data->first()->f_time;
            $s_time = $doc_data->first()->s_time;

            $day = $doc_data->first()->day;

            $date1 = "1970-01-01 " . $f_time;

            $date2 = "1970-01-01 " . $s_time;

            $date1 = strtotime($date1);

            $date2 = strtotime($date2);

            $diff = abs($date2 - $date1);

            $years = floor($diff / (365 * 60 * 60 * 24));

            $months = floor(($diff - $years * 365 * 60 * 60 * 24)

                / (30 * 60 * 60 * 24));

            $days = floor(($diff - $years * 365 * 60 * 60 * 24 -

                    $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

            $hours = floor(($diff - $years * 365 * 60 * 60 * 24

                    - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)

                / (60 * 60));

            $minutes = floor(($diff - $years * 365 * 60 * 60 * 24

                    - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24

                    - $hours * 60 * 60) / 60);

            $seconds = floor(($diff - $years * 365 * 60 * 60 * 24

                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24

                - $hours * 60 * 60 - $minutes * 60));

            $f_time = strtotime($f_time);
            $loop_length = ($hours * 4);
            $timeList = array();
            $time_loop = 1;
            $return_data_array = [];
            for ($k = 1; $k <= $loop_length; $k++) {
                if ($k == 1) {
                    $start_time = date("H:i", strtotime('+0 minutes', $f_time));
                    ?>

                    <?php
                } else {
                    $start_time = date("H:i", strtotime("+$this->appointment_schedule minutes", $f_time));
                    $f_time = strtotime($start_time);
                    ?>

                <?php }

                $url = url('app-booking/' . $doctor . '/' . $hospital . '/' . $day . '/' . $start_time);

                $zzz = $T . '-' . $time_loop;

                $timeConverter = date('H:i:s', strtotime($start_time));

                $date_data = date('h:i a', strtotime($start_time));
//dd($timeConverter);
                if (in_array($timeConverter, $previous_appointment_data)) {
                    $html = '<li style="line-height: 50px" class="list-inline-item"><button class="btn btn-outline-primary isDisabled" disabled >' . $date_data . '</button></li><input type="hidden" value=' . $url . ' id=' . 'url' . $time_loop . '>';
                } else {
                    $html = '<li style="line-height: 50px" class="list-inline-item"><a onclick="check_field_hos(' . $T . ',' . $time_loop . ')" class="btn btn-outline-primary">' . $date_data . '</a></li><input type="hidden" value=' . $url . ' id=' . 'url' . $time_loop . '>';
                }

                array_push($return_data_array, $html);


                ?>
                <?php
                $time_loop++;
            }
        }
        //print_r($return_data_array);exit();
        return $return_data_array;
    }

    function getSheduleClinic(Request $request)
    {
        $T = $request->T;
        $date = date('Y-m-d', strtotime($request->date));
        $day = date('D', strtotime($request->date));
        $hospital = DoctorsClinicDetails::where('id', $request->hospital)->first()->clinic;//clinic
        $doctor = $request->doctor;
        $doc_data = DoctorsClinicDetails::select('id', 'f_time', 's_time', 'day', 'clinic')->where('day', $day)->where('clinic', $hospital)->where('doctor_id', $doctor)->get();

        //Previous Appointment
        $clinic_array = [];
        $probable_clinics = DoctorsClinicDetails::select('id')->where('clinic', $hospital)->get();

        if ($probable_clinics) {
            foreach ($probable_clinics as $clinic_val) {
                $val = '0' . $clinic_val->id;
                array_push($clinic_array, $val);
            }

            $previous_appointment_data = PatientAppointmentDetails::where('date', $date)->where('day', $day)->whereIn('hospital_id', $clinic_array)->pluck('schedule')->toArray();

        }
        //End
        if ($doc_data->count() > 0) {
            $f_time = $doc_data->first()->f_time;
            $s_time = $doc_data->first()->s_time;

            $day = $doc_data->first()->day;

            $date1 = "1970-01-01 " . $f_time;

            $date2 = "1970-01-01 " . $s_time;

            $date1 = strtotime($date1);

            $date2 = strtotime($date2);

            $diff = abs($date2 - $date1);

            $years = floor($diff / (365 * 60 * 60 * 24));

            $months = floor(($diff - $years * 365 * 60 * 60 * 24)

                / (30 * 60 * 60 * 24));

            $days = floor(($diff - $years * 365 * 60 * 60 * 24 -

                    $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

            $hours = floor(($diff - $years * 365 * 60 * 60 * 24

                    - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)

                / (60 * 60));

            $minutes = floor(($diff - $years * 365 * 60 * 60 * 24

                    - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24

                    - $hours * 60 * 60) / 60);

            $seconds = floor(($diff - $years * 365 * 60 * 60 * 24

                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24

                - $hours * 60 * 60 - $minutes * 60));

            $f_time = strtotime($f_time);
            $loop_length = ($hours * 4);
            $timeList = array();
            $time_loop = 1;
            $return_data_array = [];
            for ($k = 1; $k <= $loop_length; $k++) {
                if ($k == 1) {
                    $start_time = date("H:i:s", strtotime('+0 minutes', $f_time));
                    //array_push($return_data_array,$start_time);
                    ?>

                    <?php
                } else {
                    $start_time = date("H:i:s ", strtotime("+$this->appointment_schedule minutes", $f_time));
                    $f_time = strtotime($start_time);
                    //array_push($return_data_array,$start_time);
                    ?>

                <?php }

                $url = url('clinic-app-booking/' . $doctor . '/0' . $doc_data->first()->id . '/' . $day . '/' . $start_time);

                $timeConverter = date('H:i:s', strtotime($start_time));

                $date_data = date('h:i a', strtotime($start_time));

                if (in_array($timeConverter, $previous_appointment_data)) {

                    $html = '<li style="line-height: 50px" class="list-inline-item"><button class="btn btn-outline-primary isDisabled" disabled >' . $date_data . '</button></li><input type="hidden" value=' . $url . ' id=' . 'url' . $time_loop . '>';
                } else {
                    $html = '<li style="line-height: 50px" class="list-inline-item"><a onclick="check_field_clinic(' . $T . ',' . $time_loop . ')" class="btn btn-outline-primary">' . $date_data . '</a></li><input type="hidden" value=' . $url . ' id=' . 'url' . $time_loop . '>';
                }

                array_push($return_data_array, $html);

                ?>
                <?php
                $time_loop++;
            }
        }

        return $return_data_array;
    }
}
