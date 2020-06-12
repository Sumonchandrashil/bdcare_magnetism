<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorsClinicDetails;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\ForeignHospital;
use App\Model\BDCare\Notifications;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\PatientMedicalRecord;
use App\Model\BDCare\PatientMedication;
use App\Model\BDCare\PatientPrescriptionComments;
use App\Model\BDCare\PatientPrescriptionDetails;
use App\Model\BDCare\Setup\Hospital;
use App\Model\BlogComment;
use App\Model\PackageService\BookedPackage;
use App\Model\PackageService\BookedService;
use App\Model\PackageService\Referral;
use App\Model\Twilio\TwilioVideo;
use App\User;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use JWTFactory;
use Mpdf\Mpdf;
use Validator;

class APIPatientController extends Controller
{
    function PatientDataInsert(Request $request)
    {
        $dataUser = User::where('id', $request->get('sess_user_id'))->first();
        $user_photo = $request->file('user_photo');

        if ($user_photo) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('user_photo')) . '.' . $request->file('user_photo')->getClientOriginalExtension();

            $request->file('user_photo')->move('uploads/user_photo/', $imgName);

            if (file_exists('uploads/user_photo/' . $dataUser->user_photo) AND !empty($dataUser->user_photo)) {
                unlink('uploads/user_photo/' . $dataUser->user_photo);
            }

            $data_info['user_photo'] = $imgName;
            User::where('id', $request->get('sess_user_id'))->update($data_info);
        }

        try {
            DB::beginTransaction();

            $data_patient = array(

                'patient_name' => $request->get('patient_name'),
                'email' => $request->get('email'),
                'address' => $request->get('address'),
                'contact' => $request->get('contact'),
                'gender' => $request->get('gender'),
                'details' => $request->get('details'),
                'occupation' => $request->get('occupation'),
                //'status' => $request->get('status')
            );

            PatientData::where('created_by', $request->get('sess_user_id'))->update($data_patient);

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

    function PatientMedicationInsert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medication_name' => 'required',
        ]);

        if ($validator->fails()) {
            $data['status'] = false;
            $data['message'] = 'Validation Failed';
            return response()->json($data);
        }

        try {
            DB::beginTransaction();

            PatientMedication::create([
                'medication_name' => $request->get('medication_name'),
                'description' => $request->get('description'),
                'status' => $request->get('status'),
                'created_by' => $request->get('sess_user_id'),
            ]);

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

    function PatientWiseMedication(Request $request)
    {
        $data = PatientMedication::where('created_by', $request->sess_user_id)->get();
        return response()->json(compact('data'));
    }

    function PatientWiseMedicationDelete(Request $request)
    {
        try {
            DB::beginTransaction();

            PatientMedication::findOrFail($request->id)->forceDelete();

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

    function PatientWiseMedicationUpdate(Request $request)
    {
        $data2 = array(
            'medication_name' => $request->medication_name,
            'description' => $request->detail,
            'updated_by' => $request->updated_by_user,
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $request->status
        );

        try {
            DB::beginTransaction();

            PatientMedication::where('id', $request->id)->update($data2);

            DB::commit();

            $data['status'] = true;
            $data['message'] = 'Success';

            return response()->json($data);

        } catch (Exception $e) {
            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';

            return response()->json($data);
        }
    }

    function SinglePatientData(Request $request)
    {
        $data = PatientData::with('get_photo')->where('created_by', $request->patient_id)->orderBy('patient_name', 'asc')->get()->first();
        return response()->json($data);
    }

    function SinglePatientDataById(Request $request)
    {
        $data = PatientData::with('get_photo')->Find($request->patient_id);
        return response()->json($data);
    }

    function AppointmentBooking(Request $request)
    {
        $data2 = array(
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'hospital_id' => $request->hospital_id,
            'schedule' => $request->schedule,
            'day' => date('D', strtotime($request->day)),
            'date' => date('Y-m-d', strtotime($request->day)),
            'status' => $request->status
        );

        try {
            DB::beginTransaction();

            $app_check = PatientAppointmentDetails::where('doctor_id', $request->doctor_id)->where('hospital_id', $request->hospital_id)->where('schedule', $request->schedule)->where('date', dateConvertFormtoDB($request->day))->count();
            //print_r($data2);exit();
            if ($app_check > 0) {
                $data['status'] = false;
                $data['message'] = 'Already Booked';

                return response()->json($data);
            }

            PatientAppointmentDetails::insert($data2);

            DB::commit();

            $doctor_name = DoctorsData::where('created_by', $request->doctor_id)->first() ? DoctorsData::where('created_by', $request->doctor_id)->first()->doctor_name : '';
            $patient_name = PatientData::where('created_by', $request->patient_id)->first() ? PatientData::where('created_by', $request->patient_id)->first()->patient_name : '';
            $hospital_name = Hospital::where('id', $request->hospital_id)->first() ? Hospital::where('id', $request->hospital_id)->first()->hospital_name : '';
            $time = date('d-m-Y', strtotime($request->day)) . '>' . date('H:i:s A', strtotime($request->schedule));
            $msg = 'Dear Doctor ' . $doctor_name . ' one patient named ' . $patient_name . ' want to have a booking at ' . $hospital_name . ' on ' . $time;
            $token = User::where('id', $request->doctor_id)->first() ? User::where('id', $request->doctor_id)->first()->token : '';//"d8FTrbC1Srk:APA91bGgjyqE1fEX1hCsbxcC66oA0q7HfDX6ykgoFif43-0vgvfh9uTY0szvDNFtIrfZed0Zm3Es3pu1JyR-dag0YA5i8nIVwuR_NGQBF4_NFeKhz9v0BawboIIFfX49xTkM_AtlX8J_";
            $title = "Booking Request";

            $data_not = array(

                'title' => $title,
                'details' => $msg,
                'key_note' => 'appointment',
                'created_by' => Auth::user()->id,
                'created_for' => $request->doctor_id,
            );

            Notifications::insert($data_not);

            if ($token != '') {
                push_notification($title, $msg, $token);
            }

            $data['status'] = true;
            $data['message'] = 'Success';

            return response()->json($data);

        } catch (Exception $e) {

            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';

            return response()->json($data);
        }
    }

    function AppointmentData(Request $request)
    {
        $new_array = [];

        if ($request->patient_id) {
            //$data = PatientAppointmentDetails::with('get_clinic')->with('get_patient')->with('get_doctor')->with('get_hospital')->where('patient_id',$request->patient_id)->get();

            $data = PatientAppointmentDetails::where('patient_id', $request->patient_id)
                ->orderBy('date', 'desc')
                ->get();
            //echo $data->count();exit();
            foreach ($data as $rowDoc) {
                $clinic_id = '';
                $hospital_id = $rowDoc->hospital_id;

                $cl = substr($hospital_id, 0, 1);

                if ($cl == 0) {
                    $clinic_id = ltrim($hospital_id, 0);
                    $get_clinic = DoctorsClinicDetails::with('get_city', 'get_area')
                        ->where('id', $clinic_id)
                        ->first();
                } else {
                    $get_clinic = null;
                }

                $new_array[] = [
                    'id' => $rowDoc->id,
                    'patient_id' => $rowDoc->patient_id,
                    'doctor_id' => $rowDoc->doctor_id,
                    'hospital_id' => $hospital_id,
                    'schedule' => $rowDoc->schedule,
                    'day' => $rowDoc->day,
                    'date' => $rowDoc->date,
                    'status' => $rowDoc->status,
                    'get_clinic' => $get_clinic,
                    'get_hospital' => $rowDoc->get_hospital,
                    'get_patient' => $rowDoc->get_patient,
                    'get_doctor' => $rowDoc->get_doctor,
                    'doctor_image' => User::where('id', $rowDoc->doctor_id)->first()->user_photo,
                    'patient_image' => User::where('id', $rowDoc->patient_id)->first()->user_photo,
                ];
            }
            //array_push($doc_array,$rowDoc->get_doctor->created_by);

        } elseif ($request->doctor_id) {
            $data = PatientAppointmentDetails::where('doctor_id', $request->doctor_id)
                ->orderBy('date', 'desc')
                ->get();

            foreach ($data as $rowDoc) {
                $clinic_id = '';
                $hospital_id = $rowDoc->hospital_id;

                $cl = substr($hospital_id, 0, 1);

                if ($cl == 0) {
                    $clinic_id = ltrim($hospital_id, 0);
                    $get_clinic = DoctorsClinicDetails::with('get_city', 'get_area')
                        ->where('id', $clinic_id)
                        ->first();
                } else {
                    $get_clinic = null;
                }

                $new_array[] = [
                    'id' => $rowDoc->id,
                    'patient_id' => $rowDoc->patient_id,
                    'doctor_id' => $rowDoc->doctor_id,
                    'hospital_id' => $hospital_id,
                    'schedule' => $rowDoc->schedule,
                    'day' => $rowDoc->day,
                    'date' => $rowDoc->date,
                    'status' => $rowDoc->status,
                    'get_clinic' => $get_clinic,
                    'get_hospital' => $rowDoc->get_hospital,
                    'get_patient' => $rowDoc->get_patient,
                    'get_doctor' => $rowDoc->get_doctor,
                    'doctor_image' => User::where('id', $rowDoc->doctor_id)->first()->user_photo,
                    'patient_image' => User::where('id', $rowDoc->patient_id)->first()->user_photo,
                ];
            }
            //array_push($doc_array,$rowDoc->get_doctor->created_by);
        }

        return response()->json($new_array);
    }

    public function AppointmentDataEdit(Request $request)
    {

        $data = PatientAppointmentDetails::with('get_doctor', 'get_hospital')->where('id', $request->id)->first();

        return response()->json($data);
    }

    function UpdateAppointmentData(Request $request)
    {
        $day = date('D', strtotime($request->day));

        $data2 = [

            'doctor_id' => $request->doctor_id,
            'hospital_id' => $request->hospital_id,
            'schedule' => $request->schedule,
            'day' => $day,
            'date' => $request->day,
            'updated_by' => $request->user_id,

        ];

        try {
            DB::beginTransaction();

            $app_check = PatientAppointmentDetails::where('doctor_id', $request->doctor_id)->where('hospital_id', $request->hospital_id)->where('schedule', $request->schedule)->where('date', dateConvertFormtoDB($request->day))->count();
            //print_r($data2);exit();
            if ($app_check > 0) {
                $data['status'] = false;
                $data['message'] = 'Already Booked';

                return response()->json($data);
            } else {
                PatientAppointmentDetails::findOrFail($request->id)->update($data2);

                DB::commit();

                $data['status'] = true;
                $data['message'] = 'Success';

                return response()->json($data);
            }


        } catch (Exception $e) {

            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';

            return response()->json($data);
        }
    }

    function PatientAppointmentDelete(Request $request)
    {


        try {
            DB::beginTransaction();

            PatientAppointmentDetails::findOrFail($request->id)->forceDelete();

            DB::commit();

            $data['status'] = true;
            $data['message'] = 'Success';

            return response()->json($data);

        } catch (Exception $e) {

            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';

            return response()->json($data);
        }
    }

    public function ViewPrescriptionDataFromPatient(Request $request)
    {

        $data = PatientPrescriptionDetails::where('booking_id', $request->booking_id)->get()->first();

        return response()->json($data);

    }

    function PatientMedicalRecords()
    {
        $PatientMedicalRecord = PatientMedicalRecord::orderBy('title', 'asc')->get();


        return response()->json(compact('PatientMedicalRecord'));
    }

    function PatientWiseMedicalRecord(Request $request)
    {
        $PatientWiseMedicalRecord = PatientMedicalRecord::where('created_by', $request->patient_id)->orderBy('title', 'asc')->get();


        return response()->json(compact('PatientWiseMedicalRecord'));
    }


    function PatientMedicalRecordInsert(Request $request)
    {
        try {
            $dataDOc = PatientMedicalRecord::where('created_by', $request->get('patient_id'))->first();

            $data_doc = array(

                'created_by' => $request->get('patient_id'),
                'title' => $request->get('title'),

            );
            DB::beginTransaction();

            $image = $request->file('image');

            $data_doc['updated_by'] = Auth::user()->id;

            if ($image) {
                //echo $request->file('image');
                $imgName = md5(str_random(30) . time() . '_' . $request->file('image')) . '.' . $request->file('image')->getClientOriginalExtension();
                //echo $imgName.'----';exit;
                $request->file('image')->move('uploads/medical_records/', $imgName);

                $data_doc['image'] = $imgName;

            }

            PatientMedicalRecord::create($data_doc);

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

    function PatientWiseMedicalRecordUpdate(Request $request)
    {

        try {
            $dataDOc = PatientMedicalRecord::where('id', $request->id)->where('created_by', $request->get('patient_id'))->first();

            $data_doc = array(

                'title' => $request->get('title'),
                'updated_by' => Auth::user()->id,
            );

            DB::beginTransaction();

            $image = $request->file('image');

            $data_doc['updated_by'] = Auth::user()->id;

            if ($image) {

                $imgName = md5(str_random(30) . time() . '_' . $request->file('image')) . '.' . $request->file('image')->getClientOriginalExtension();

                $request->file('image')->move('uploads/medical_records/', $imgName);

                if (file_exists('uploads/medical_records/' . $dataDOc->image) AND !empty($dataDOc->image)) {
                    unlink('uploads/medical_records/' . $dataDOc->image);
                }

                $data_doc['image'] = $imgName;

            }

            PatientMedicalRecord::where('id', $request->id)->update($data_doc);

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();

        } catch (Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();

            $data['status'] = false;
            $data['message'] = $msg;
        }

        return response()->json($data);
    }

    function PatientWiseMedicalRecordDelete(Request $request)
    {
        try {

            DB::beginTransaction();

            PatientMedicalRecord::FindOrFail($request->id)->forceDelete();

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

    function OrderList(Request $request)
    {
        $PatientRecord = BookedPackage::join('health_packages', function ($join) {
            $join->on('booked_packages.package_id', '=', 'health_packages.id');
            $join->on('booked_packages.package_id', '!=', DB::raw("''"));
        })
            ->where('booked_packages.created_by', Auth::user()->id)
            ->get();
        return response()->json(compact('PatientRecord'));
    }

    function ServiceList(Request $request)
    {
        $services = BookedService::join('services', function ($join) {
            $join->on('booked_services.service_id', '=', 'services.id');
            $join->on('booked_services.service_id', '!=', DB::raw("''"));
        })
            ->where('booked_services.created_by', Auth::user()->id)
            ->select(
                'booked_services.bookdate as book_date',
                'booked_services.name as patient_name',
                'booked_services.address as patient_address',
                'booked_services.age as patient_age',
                'booked_services.gender as patient_gender',
                'booked_services.number as patient_mobile',
                'booked_services.email as patient_email',

                'services.name as service_name',
                'services.terms as service_terms',
                'services.conditions as service_conditions',
                'services.details as service_details',
                'services.service_date as service_date',
                'services.hot_line_number as service_hot_line_number',
                'services.image as service_image'
            )
            ->get();
        return response()->json($services);
    }

    function CommentList(Request $request)
    {
        $BlogComment = BlogComment::with('user')->where('blog_id', $request->blog_id)->get();
        return response()->json(compact('BlogComment'));
    }

    function AddComment(Request $request)
    {
        try {
            $comment = [
                'comment' => $request->comment,
                'blog_id' => $request->blog_id,
                'parent_id' => $request->blog_id,
                'created_by' => $request->user_id,
                'reply' => 0,
            ];

            DB::beginTransaction();


            BlogComment::insert($comment);

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

    function AddRating(Request $request)
    {
        try {
            $rating = [
                'rating' => $request->rating,
            ];
            DB::beginTransaction();

            PatientPrescriptionDetails::where('id', $request->prescription_id)->update($rating);

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

    function AddRatingToHealthQuestion(Request $request)
    {
        try {
            $rating = [
                'rating' => $request->rating,
            ];

            DB::beginTransaction();

            PatientPrescriptionDetails::where('id', $request->row_id)->update($rating);

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

    function AddCommentPrescription(Request $request)
    {
        try {
            $review = [
                'comment' => $request->comment,
                'prescription_id' => $request->prescription_id,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $request->user_id,
            ];

            DB::beginTransaction();

            PatientPrescriptionComments::insert($review);

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

    function patientCommentList(Request $request)
    {
        $data = PatientPrescriptionComments::with('get_photo')->where('created_by', $request->patient_id)->get();
        return response()->json(compact('data'));
    }

    function DocDateDataUsingHospital(Request $request)
    {
        $new = [];
        $formatted_data = [];
        $counter = 15;
        $doc_id = $request->doc_id;
        $hospital_id = $request->hospital_id;

        $DoctorsHospitalDays = DoctorsHospitalDetails::select('day')->where('doctor_id', $doc_id)->where('hospital_id', $hospital_id)->get();

        if (count($DoctorsHospitalDays) > 0) {
            foreach ($DoctorsHospitalDays as $row_data) {
                array_push($new, $row_data->day);
            }

            for ($i = 0; $i < $counter; $i++) {
                $plus_date_day = date('D', strtotime("+$i days"));

                if (in_array($plus_date_day, $new)) {
                    $plus_date = date('d-m-Y', strtotime("+$i days"));

                    $formatted_data[] = array(
                        'date' => $plus_date,
                    );
                }
            }
            return response()->json($formatted_data);
        } else {
            $data = [];
            return response()->json($data);
        }
    }

    function DocDateDataUsingClinic(Request $request)
    {
        $new = [];
        $formatted_data = [];
        $counter = 15;
        $doc_id = $request->doc_id;
        $clinic_id = $request->clinic_id;

        $DoctorsClinicName = DoctorsClinicDetails::where('id', $clinic_id)->first();

        if ($DoctorsClinicName) {
            $DoctorsClinicDays = DoctorsClinicDetails::select('day')->where('clinic', $DoctorsClinicName->clinic)->where('doctor_id', $doc_id)->get();

            if ($DoctorsClinicDays->count() > 0) {
                foreach ($DoctorsClinicDays as $row_data) {
                    array_push($new, $row_data->day);
                }

                for ($i = 0; $i < $counter; $i++) {
                    $plus_date_day = date('D', strtotime("+$i days"));

                    if (in_array($plus_date_day, $new)) {
                        $plus_date = date('d-m-Y', strtotime("+$i days"));

                        $formatted_data[] = array(
                            'date' => $plus_date,
                        );
                    }
                }
                return response()->json($formatted_data);
            } else {
                $data = [];
                return response()->json($data);
            }
        } else {
            $data = [];
            return response()->json($data);
        }
    }

    function ViewPrescription($bookingID)
    {

        $prescription = PatientPrescriptionDetails::with('get_doctor', 'get_patient')->where('booking_id', $bookingID)->get()->first();

        $degreeIDs = DB::table('doctors_degree_details')->where('doctor_id', $prescription->get_doctor->created_by)->pluck('degree_id');
        $degrees = DB::table('degrees')->select('degree_name')->whereIn('id', $degreeIDs)->get();

        $data = array(
            'prescription' => $prescription,
            'degrees' => $degrees,
        );
        $html = View::make('backend.patient.prescriptionPrint')->with($data);

        $mpdf = new Mpdf([
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 48,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("BDCare - Prescription");
        $mpdf->SetAuthor("BDCare");
        $mpdf->SetWatermarkText("BDCare");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.05;
        $mpdf->SetDisplayMode('fullpage');
        // $stylesheet = file_get_contents(public_path().'/css/mpdf.css');
        // $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($html);
        $mpdf->Output("BDCare_Prescription_$bookingID.pdf", 'I');
    }

    function referral_data(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $time = Carbon::now();

            $medical_report = $request->file('medical_report');
            if ($medical_report) {
                $imgName = md5(str_random(30) . time() . '_' . $medical_report) . '.' . $medical_report->getClientOriginalExtension();
                $medical_report->move('uploads/medical_report/', $imgName);
            }

            $referral = [
                'patient_name' => $request->patient_name,
                'patient_age' => $request->patient_age,
                'care_giver_name' => $request->care_giver_name,
                'care_giver_age' => $request->care_giver_age,
                'passport_no' => $request->passport_no,
                'wheel_chair' => $request->wheel_chair,
                'address' => $request->address,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
                'date_of_travel' => $request->date_of_travel,
                'foreign_hospital_id' => $request->foreign_hospital_id,
                'medical_report' => $medical_report,
                'created_by' => $user_id,
                'created_at' => $time,
            ];

            DB::beginTransaction();

            Referral::create($referral);

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    public function reportPatient()
    {
        $user_id = Auth::user()->id;

        try {
            $data = TwilioVideo::join('twilio_video_logs', 'twilio_videos.id', '=', 'twilio_video_logs.twilio_video_id')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'twilio_video_logs.ParticipantIdentity');
                    $join->on('users.id', '!=', DB::raw("''"));
                })
                ->where('twilio_videos.callerUserId', '=', $user_id)
                ->select([
//                    'twilio_video_logs.id',
                    'users.user_name as participant',
//                    'twilio_video_logs.twilio_video_id',
//                    'twilio_video_logs.SequenceNumber',
                    'twilio_video_logs.ParticipantStatus as status',
//                    'twilio_video_logs.ParticipantIdentity',
//                    'twilio_video_logs.StatusCallbackEvent',
//                    'twilio_video_logs.TrackKind',
                    'twilio_video_logs.ParticipantDuration as duration',
//                    'twilio_video_logs.RawData',
                    'twilio_video_logs.created_at as date'
                ])
                ->get();
        } catch (Exception $e) {
            $data = [];
        }

        return response()->json($data);
    }

    public function foreignHospitals()
    {
        $data = ForeignHospital::join('countries', 'foreign_hospitals.country_id', '=', 'countries.id')
            ->where('status', 1)
            ->select(
                'countries.country_name',
                'foreign_hospitals.hospital_name',
                'foreign_hospitals.address'
            )
            ->get();

        return response()->json($data);
    }

    public function referral_country(Request $request)
    {
        $data = ForeignHospital::query()
            ->join('countries', 'foreign_hospitals.country_id', '=', 'countries.id')
            ->select('countries.id', 'countries.country_name')
            ->distinct()
            ->get();
        return response()->json($data);
    }

    public function referral_hospital(Request $request)
    {
        $data = ForeignHospital::where('status', 1);
        if ($request->country_id) {
            $data = $data->where('country_id', $request->country_id);
        }
        $data = $data->select('id', 'hospital_name', 'address')->get();
        return response()->json($data);
    }
}
