<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorOffDaysDetails;
use App\Model\BDCare\DoctorsClinicDetails;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\DoctorsDegreeDetails;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\DoctorsSpecialityDetails;
use App\Model\BDCare\HealthQuestionReview;
use App\Model\BDCare\Notifications;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\PatientPrescriptionComments;
use App\Model\BDCare\PatientPrescriptionDetails;
use App\Model\BDCare\Setup\Hospital;
use App\Model\PackageService\HealthArticle;
use App\Model\Twilio\TwilioVideo;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use JWTAuth;
use JWTFactory;
use Validator;

class APIDoctorController extends Controller
{
    function DocDataUsingSpeciality(Request $request)
    {
        $new_array = [];
        $data = [];
        $doc_array = [];
        $speciality_id = $request->speciality_id;
        $city_id = $request->city_id;
        $area_id = $request->area_id;

        $DocDatas = DoctorsSpecialityDetails::with('doctor_image')->with('get_hospital')->with('get_doctor')->where('speciality_id', $speciality_id)->get();

        if ($DocDatas->count() > 0) {

            $i = 0;

            foreach ($DocDatas as $rowDoc) {

                if ($rowDoc->get_doctor) {
                    if ($rowDoc->get_doctor->status == 1) {
                        $doctor_hospital = DoctorsHospitalDetails::where('doctor_id', $rowDoc->get_doctor->created_by)->get();
                        $doctor_Cliic = DoctorsClinicDetails::where('area', $area_id)->where('city', $city_id)->where('doctor_id', $rowDoc->get_doctor->created_by)->get();

                        foreach ($doctor_Cliic as $doc_cl) {
                            if (!in_array($rowDoc->get_doctor->created_by, $doc_array)) {
                                $new_array[] = [

                                    'doctor_id' => $rowDoc->get_doctor ? $rowDoc->get_doctor->created_by : '',
                                    'doctor_name' => $rowDoc->get_doctor ? $rowDoc->get_doctor->doctor_name : '',
                                    'speciality_id' => $DocDatas[$i]->speciality_id,
                                    'remarks' => $DocDatas[$i]->remarks,
                                    'user_photo' => User::where('id', $rowDoc->get_doctor->created_by)->first()->user_photo,
                                    'visiting_fees' => $rowDoc->get_doctor ? $rowDoc->get_doctor->visiting_fees : '',
                                    'messaging_fees' => $rowDoc->get_doctor ? $rowDoc->get_doctor->messaging_fees : '',
                                    'emergency_contact' => $rowDoc->get_doctor ? $rowDoc->get_doctor->emergency_contact : '',
                                    'email' => $rowDoc->get_doctor ? $rowDoc->get_doctor->email : '',
                                    'gender' => $rowDoc->get_doctor ? $rowDoc->get_doctor->gender : '',
                                    'address' => $rowDoc->get_doctor ? $rowDoc->get_doctor->address : '',
                                    'institute' => $rowDoc->get_doctor ? $rowDoc->get_doctor->summary : '',
                                    'current_designation' => $rowDoc->get_doctor ? $rowDoc->get_doctor->current_designation : '',
                                    'year_of_experience' => $rowDoc->get_doctor ? $rowDoc->get_doctor->year_of_experience : '',
                                    'rating' => $rowDoc->get_doctor ? $rowDoc->get_doctor->rating : '',
                                    'bmdc_reg_no' => $rowDoc->get_doctor ? $rowDoc->get_doctor->bmdc_reg_no : '',
                                    'bmdc_reg_year' => $rowDoc->get_doctor ? $rowDoc->get_doctor->bmdc_reg_year : '',
                                    'bmdc_doc' => $rowDoc->get_doctor ? $rowDoc->get_doctor->bmdc_doc : '',
                                    'passport_doc' => $rowDoc->get_doctor ? $rowDoc->get_doctor->passport_doc : '',
                                    'degree' => DoctorsDegreeDetails::with('get_degree')->where('doctor_id', $rowDoc->get_doctor->created_by)->get(),
                                ];
                            }
                            array_push($doc_array, $rowDoc->get_doctor->created_by);


                        }

                        foreach ($doctor_hospital as $doc_hos) {
                            $hospital_count = Hospital::where('area', $area_id)->where('city', $city_id)->where('id', $doc_hos->hospital_id)->get();

                            if ($hospital_count->count() > 0) {
                                if (!in_array($rowDoc->get_doctor->created_by, $doc_array)) {
                                    $new_array[] = [

                                        'doctor_id' => $rowDoc->get_doctor ? $rowDoc->get_doctor->created_by : '',
                                        'doctor_name' => $rowDoc->get_doctor ? $rowDoc->get_doctor->doctor_name : '',
                                        'speciality_id' => $DocDatas[$i]->speciality_id,
                                        'remarks' => $DocDatas[$i]->remarks,
                                        'user_photo' => User::where('id', $rowDoc->get_doctor->created_by)->first()->user_photo,
                                        'visiting_fees' => $rowDoc->get_doctor ? $rowDoc->get_doctor->visiting_fees : '',
                                        'messaging_fees' => $rowDoc->get_doctor ? $rowDoc->get_doctor->messaging_fees : '',
                                        'emergency_contact' => $rowDoc->get_doctor ? $rowDoc->get_doctor->emergency_contact : '',
                                        'email' => $rowDoc->get_doctor ? $rowDoc->get_doctor->email : '',
                                        'gender' => $rowDoc->get_doctor ? $rowDoc->get_doctor->gender : '',
                                        'address' => $rowDoc->get_doctor ? $rowDoc->get_doctor->address : '',
                                        'institute' => $rowDoc->get_doctor ? $rowDoc->get_doctor->summary : '',
                                        'current_designation' => $rowDoc->get_doctor ? $rowDoc->get_doctor->current_designation : '',
                                        'year_of_experience' => $rowDoc->get_doctor ? $rowDoc->get_doctor->year_of_experience : '',
                                        'rating' => $rowDoc->get_doctor ? $rowDoc->get_doctor->rating : '',
                                        'bmdc_reg_no' => $rowDoc->get_doctor ? $rowDoc->get_doctor->bmdc_reg_no : '',
                                        'bmdc_reg_year' => $rowDoc->get_doctor ? $rowDoc->get_doctor->bmdc_reg_year : '',
                                        'bmdc_doc' => $rowDoc->get_doctor ? $rowDoc->get_doctor->bmdc_doc : '',
                                        'passport_doc' => $rowDoc->get_doctor ? $rowDoc->get_doctor->passport_doc : '',
                                        'degree' => DoctorsDegreeDetails::with('get_degree')->where('doctor_id', $rowDoc->get_doctor->created_by)->get(),
                                    ];
                                }
                                array_push($doc_array, $rowDoc->get_doctor->created_by);
                            }
                        }

                    }

                }
                $i++;
            }

            return response()->json($new_array);

        } else {

            $data['status'] = false;
            $data['message'] = 'No Data Found';

            return response()->json($data);

        }
    }

    function DoctorInformation(Request $request)
    {
        try {
            DB::beginTransaction();

            $dataDOc = DoctorsData::where('created_by', $request->get('sess_user_id'))->first();
            $dataUser = User::where('id', $request->get('sess_user_id'))->first();

            if (isset($request->doctor_name)) {
                $data_doc['doctor_name'] = $request->doctor_name;
            }
            if (isset($request->visiting_fees)) {
                $data_doc['visiting_fees'] = $request->visiting_fees;
            }
            if (isset($request->emergency_contact)) {
                $data_doc['emergency_contact'] = $request->emergency_contact;
            }
            if (isset($request->email)) {
                $data_doc['email'] = $request->email;
            }
            if (isset($request->gender)) {
                $data_doc['gender'] = $request->gender;
            }
            if (isset($request->address)) {
                $data_doc['address'] = $request->address;
            }
            if (isset($request->current_designation)) {
                $data_doc['current_designation'] = $request->current_designation;
            }
            if (isset($request->year_of_experience)) {
                $data_doc['year_of_experience'] = $request->year_of_experience;
            }
            if (isset($request->bmdc_reg_no)) {
                $data_doc['bmdc_reg_no'] = $request->bmdc_reg_no;
            }
            if (isset($request->bmdc_reg_year)) {
                $data_doc['bmdc_reg_year'] = $request->bmdc_reg_year;
            }
            if (isset($request->summary)) {
                $data_doc['summary'] = $request->summary;
            }

            $image = $request->file('bmdc_doc');
            $user_photo = $request->file('user_photo');
            $image_id = $request->file('passport_nid');

            $data_doc['updated_by'] = Auth::user()->id;

            if ($image) {

                $imgName = md5(str_random(30) . time() . '_' . $request->file('bmdc_doc')) . '.' . $request->file('bmdc_doc')->getClientOriginalExtension();
                //echo $imgName; exit;
                $request->file('bmdc_doc')->move('uploads/doctor_bmdc_doc/', $imgName);

                if (file_exists('uploads/doctor_bmdc_doc/' . $dataDOc->bmdc_doc) AND !empty($dataDOc->bmdc_doc)) {
                    unlink('uploads/doctor_bmdc_doc/' . $dataDOc->bmdc_doc);
                }

                $data_doc['bmdc_doc'] = $imgName;

            }

            if ($image_id) {

                $imgName = md5(str_random(30) . time() . '_' . $request->file('passport_nid')) . '.' . $request->file('passport_nid')->getClientOriginalExtension();

                $request->file('passport_nid')->move('uploads/doctor_passport_nid/', $imgName);
                if (file_exists('uploads/doctor_passport_nid/' . $dataDOc->passport_nid) AND !empty($dataDOc->passport_nid)) {
                    unlink('uploads/doctor_passport_nid/' . $dataDOc->passport_nid);
                }
                $data_doc['passport_nid'] = $imgName;

            }

            if ($user_photo) {

                $imgName = md5(str_random(30) . time() . '_' . $request->file('user_photo')) . '.' . $request->file('user_photo')->getClientOriginalExtension();

                $request->file('user_photo')->move('uploads/user_photo/', $imgName);
                if (file_exists('uploads/user_photo/' . $dataUser->user_photo) AND !empty($dataUser->user_photo)) {
                    unlink('uploads/user_photo/' . $dataUser->user_photo);
                }
                $data_info['user_photo'] = $imgName;
                User::where('id', $request->get('sess_user_id'))->update($data_info);

            }

            DoctorsData::where('created_by', $request->get('sess_user_id'))->update($data_doc);

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

    function DoctorDoc(Request $request)
    {
        $file = base64_decode($request['bmdc_doc']);
        $folderName = 'public/uploads/';
        $safeName = str_random(10) . '.' . 'png';
        $destinationPath = public_path() . $folderName;
        $success = file_put_contents(public_path() . '/uploads/doctor_bmdc_doc/' . $safeName, $file);

        $data_doc['bmdc_doc'] = $safeName;


        $file = base64_decode($request['passport_nid']);
        $folderName = 'public/uploads/';
        $safeName = str_random(10) . '.' . 'png';
        $destinationPath = public_path() . $folderName;
        $success = file_put_contents(public_path() . '/uploads/doctor_passport_nid/' . $safeName, $file);

        $data_doc['passport_nid'] = $safeName;
    }

    function DoctorData(Request $request)
    {   //view profile Image
        $docData = DoctorsData::with('get_photo')->where('created_by', $request->user()->id)->get()->first();
        return response()->json($docData);
    }

    function DoctorDegreeAdd(Request $request)
    {
        try {
            $data_doc = array(

                'doctor_id' => $request->get('doctor_id'),
                'degree_id' => $request->get('degree_id'),
                'institute' => $request->get('institute'),

            );
            DB::beginTransaction();

            DoctorsDegreeDetails::insert($data_doc);

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

    function DoctorDegreeEdit(Request $request)
    {
        try {
            $data_doc = array(

                'doctor_id' => $request->get('doctor_id'),
                'degree_id' => $request->get('degree_id'),
                'institute' => $request->get('institute'),

            );
            DB::beginTransaction();

            DoctorsDegreeDetails::where('id', $request->id)->update($data_doc);

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

    function DoctorWiseDegree(Request $request)
    {

        $DoctorDegreeList = DoctorsDegreeDetails::with('get_degree')->where('doctor_id', $request->doctor_id)->orderBy('id', 'asc')->get();


        return response()->json(compact('DoctorDegreeList'));
    }

    function DoctorDegreeDelete(Request $request)
    {
        try {

            DB::beginTransaction();

            DoctorsDegreeDetails::FindOrFail($request->id)->forceDelete();

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


    function DoctorSpecialityAdd(Request $request)
    {
        try {
            $data_doc = array(

                'doctor_id' => $request->get('doctor_id'),
                'speciality_id' => $request->get('speciality_id'),
                'remarks' => $request->get('remarks'),

            );
            DB::beginTransaction();

            DoctorsSpecialityDetails::insert($data_doc);

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

    function DoctorSpecialityEdit(Request $request)
    {
        try {
            $data_doc = array(

                'doctor_id' => $request->get('doctor_id'),
                'speciality_id' => $request->get('speciality_id'),
                'remarks' => $request->get('remarks'),

            );
            DB::beginTransaction();

            DoctorsSpecialityDetails::where('id', $request->id)->update($data_doc);

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


    function DoctorWiseSpeciality(Request $request)
    {

        $DoctorSpecialityList = DoctorsSpecialityDetails::with('get_hospital', 'get_speciality')->with('get_doctor')->where('doctor_id', $request->doctor_id)->orderBy('id', 'asc')->get();


        return response()->json(compact('DoctorSpecialityList'));
    }


    function DoctorSpecialityDelete(Request $request)
    {
        try {

            DB::beginTransaction();

            DoctorsSpecialityDetails::FindOrFail($request->id)->forceDelete();

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


    function DoctorHospitalAdd(Request $request)
    {
        try {
            $data_doc = array(

                'doctor_id' => $request->get('doctor_id'),
                'hospital_id' => $request->get('hospital_id'),
                'f_time' => $request->get('f_time'),
                's_time' => $request->get('s_time'),
                'day' => $request->get('day'),

            );
            DB::beginTransaction();

            DoctorsHospitalDetails::insert($data_doc);

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

    function DoctorHospitalEdit(Request $request)
    {
        try {
            $data_doc = array(

                'doctor_id' => $request->get('doctor_id'),
                'hospital_id' => $request->get('hospital_id'),
                'f_time' => $request->get('f_time'),
                's_time' => $request->get('s_time'),
                'day' => $request->get('day'),

            );
            DB::beginTransaction();

            DoctorsHospitalDetails::where('id', $request->id)->update($data_doc);

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

    function DoctorWiseHospital(Request $request)
    {

        $DoctorHospitalList = DoctorsHospitalDetails::with('get_hospital')->where('doctor_id', $request->doctor_id)->orderBy('id', 'asc')->get();


        return response()->json(compact('DoctorHospitalList'));
    }

    function DoctorWiseClinic(Request $request)
    {

        $DoctorClinicList = DoctorsClinicDetails::where('doctor_id', $request->doctor_id)->orderBy('id', 'asc')->get();


        return response()->json(compact('DoctorClinicList'));
    }

    function DoctorHospitalDelete(Request $request)
    {
        try {

            DB::beginTransaction();

            //DoctorsHospitalDetails::FindOrFail($request->id)->->forceDelete();
            DoctorsHospitalDetails::where('hospital_id', $request->hospital_id)->where('doctor_id', $request->doctor_id)->forceDelete();

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


    function ConfirmBooking(Request $request)
    {
        $data = array(
            'status' => 1,
        );

        try {
            DB::beginTransaction();

            PatientAppointmentDetails::where('id', $request->id)->update($data);

            $info = PatientAppointmentDetails::with('get_patient')->where('id', $request->id)->first();
            $patient_id = $info->patient_id;
            $patient_name = $info->get_patient ? $info->get_patient->patient_name : '';
            $hospital_name = $info->get_hospital ? $info->get_hospital->hospital_name : '';

            DB::commit();

            $data['status'] = true;
            $data['message'] = 'Success';

            $token = User::where('id', $patient_id)->first() ? User::where('id', $patient_id)->first()->token : '';

            $title = "Booking Confirmation";

            $msg = "Dear " . $patient_name . " your booking has been confirmed by the doctor at " . $hospital_name . " on " . date('d-M-y', strtotime($info->date)) . " at " . $info->schedule;

            $data_not = array(

                'title' => $title,
                'details' => $msg,
                'key_note' => 'appointment',
                'created_by' => Auth::user()->id,
                'created_for' => $request->doctor,
            );

            Notifications::insert($data_not);

            if ($token != '') {
                push_notification($title, $msg, $token);
            }


            return response()->json($data);

        } catch (Exception $e) {

            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';

            return response()->json($data);
        }
    }


    function PrescriptionAdd(Request $request)
    {

        try {
            $data_pres = array(

                'patient_id' => $request->get('patient_id'),
                'booking_id' => $request->get('booking_id'),
                'history' => $request->get('history'),
                'diagonosis' => $request->get('diagonosis'),
                'tests' => $request->get('tests'),
                'description' => $request->get('description'),
                'recommendation' => $request->get('recommendation'),
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            );
            //print_r($data_pres);

            $data__update_patient_status = array(
                'status' => 2,
            );

            DB::beginTransaction();

            PatientPrescriptionDetails::insert($data_pres);

            PatientAppointmentDetails::where('id', $request->id)->update($data__update_patient_status);

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


    public function EditPrescriptionData(Request $request)
    {

        $data = PatientPrescriptionDetails::with('get_patient', 'get_appointment', 'get_doctor')->where('booking_id', $request->booking_id)->first();

        return response()->json($data);
    }

    function UpdatePrescriptionData(Request $request)
    {
        $data2 = [

            /*'patient_id'    => $request->patient_id,
            'booking_id'    => $request->booking_id,*/
            'history' => $request->history,
            'diagonosis' => $request->diagonosis,
            'description' => $request->description,
            'recommendation' => $request->recommendation,
            'tests' => $request->tests,
            'updated_by' => $request->user_id,

        ];

        try {
            DB::beginTransaction();

            PatientPrescriptionDetails::where('booking_id', $request->booking_id)->update($data2);

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


    public function ViewPrescriptionData(Request $request)
    {
        $data = PatientPrescriptionDetails::with('get_patient', 'get_doctor')->where('booking_id', $request->booking_id)->get()->first();
        return response()->json($data);
    }

    function HealthArticleList()
    {
        $HealthArticleList = HealthArticle::with('get_doctor')->orderBy('id', 'desc')->get();
        return response()->json(compact('HealthArticleList'));
    }

    function HealthArticleListDocWise(Request $request)
    {
        $HealthArticleList = HealthArticle::where('created_by', $request->sess_user_id)->orderBy('title', 'asc')->get();
        return response()->json(compact('HealthArticleList'));
    }

    function HealthArticleAdd(Request $request)
    {
        try {
            $dataDOc = DoctorsData::where('created_by', $request->get('doctor_id'))->first();

            $data_doc = array(
                'created_by' => $request->get('doctor_id'),
                'date' => date('Y-m-d'),
                'description' => $request->get('description'),
                'title' => $request->get('title'),
            );

            DB::beginTransaction();

            $image = $request->file('image');

            $data_doc['updated_by'] = Auth::user()->id;

            if ($image) {

                $imgName = md5(str_random(30) . time() . '_' . $request->file('image')) . '.' . $request->file('image')->getClientOriginalExtension();

                $originalImage = $request->file('image');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = public_path() . '/uploads/health_article/thumb/';
                $originalPath = public_path() . '/uploads/health_article/';
                $thumbnailImage->save($originalPath . $imgName);
                $thumbnailImage->resize(370, 288);
                $thumbnailImage->save($thumbnailPath . $imgName);

                if (file_exists('public/uploads/health_article/' . $dataDOc->image) AND !empty($dataDOc->image)) {
                    unlink('public/uploads/health_article/' . $dataDOc->image);
                }

                $data_doc['image'] = $imgName;

            }
            //dd($data_doc);

            HealthArticle::insert($data_doc);

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();

            $data['status'] = false;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    function HealthArticleEdit(Request $request)
    {
        try {
            $dataDOc = DoctorsData::where('created_by', $request->get('doctor_id'))->first();

            $data_doc = array(

                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'updated_by' => Auth::user()->id,
            );

            DB::beginTransaction();

            $image = $request->file('image');

            $data_doc['updated_by'] = Auth::user()->id;

            if ($image) {

                $imgName = md5(str_random(30) . time() . '_' . $request->file('image')) . '.' . $request->file('image')->getClientOriginalExtension();

                $originalImage = $request->file('image');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = public_path() . '/uploads/health_article/thumb/';
                $originalPath = public_path() . '/uploads/health_article/';
                $thumbnailImage->save($originalPath . $imgName);
                $thumbnailImage->resize(370, 288);
                $thumbnailImage->save($thumbnailPath . $imgName);

                if (file_exists('public/uploads/health_article/' . $dataDOc->image) AND !empty($dataDOc->image)) {
                    unlink('public/uploads/health_article/' . $dataDOc->image);
                    unlink('public/uploads/health_article/thumb/' . $dataDOc->image);
                }
                $data_doc['image'] = $imgName;
            }

            HealthArticle::where('id', $request->id)->update($data_doc);

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

    function HealthArticleDelete(Request $request)
    {
        try {

            DB::beginTransaction();

            HealthArticle::FindOrFail($request->id)->forceDelete();

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

    function insert_off_days(Request $request)
    {
        try {
            DB::beginTransaction();

            $doctor_id = $request->doctor_id;
            $count_off_days = json_decode($request->date);
            $count = count($count_off_days);

            for ($i = 0; $i < $count; $i++) {
                $dates = [
                    'doctor_id' => $doctor_id,
                    'doctor_off_day' => $count_off_days[$i]->date,
                    'created_by' => Auth::user()->id,
                ];

                DoctorOffDaysDetails::insert($dates);
            }
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

    function editDoctorOffDays(Request $request)
    {
        $dataList = DoctorOffDaysDetails::where('doctor_id', $request->doctor_id)->get();
        return response()->json(compact('dataList'));
    }

    function update_off_days(Request $request)
    {
        try {
            DB::beginTransaction();

            $doctor_id = $request->doctor_id;

            $check = DoctorOffDaysDetails::where('doctor_id', $doctor_id)->get();

            if ($check->count() > 0) {
                DoctorOffDaysDetails::where('doctor_id', $doctor_id)->forceDelete();
            }

            $count_off_days = json_decode($request->date);
            $count = count($count_off_days);

            for ($i = 0; $i < $count; $i++) {
                $dates = [
                    'doctor_id' => $doctor_id,
                    'doctor_off_day' => $count_off_days[$i]->date,
                    'created_by' => Auth::user()->id,
                ];

                DoctorOffDaysDetails::insert($dates);
            }
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


    function ClinicList(Request $request)
    {
        $ClinicList = DoctorsClinicDetails::where('doctor_id', $request->doctor_id)->orderBy('clinic', 'asc')->get();

        return response()->json(compact('ClinicList'));
    }

    function ClinicAdd(Request $request)
    {
        $data = [
            'doctor_id' => $request->doctor_id,
            'clinic' => $request->clinic,
            'address' => $request->address,
            'f_time' => $request->f_time,
            's_time' => $request->s_time,
            'day' => $request->day,
            'created_by' => $request->doctor_id,
        ];

        try {

            DB::beginTransaction();

            DoctorsClinicDetails::insert($data);

            DB::commit();

            $dataResponse['status'] = true;
            $dataResponse['message'] = 'Success';

        } catch (Exception $e) {
            DB::rollback();

            $dataResponse['status'] = false;
            $dataResponse['message'] = 'Failed';
        }

        return response()->json($dataResponse);
    }

    function ClinicEdit(Request $request)
    {
        try {

            $data_clinic = array(

                'doctor_id' => $request->get('doctor_id'),
                'clinic' => $request->get('clinic'),
                'address' => $request->get('address'),
                'f_time' => $request->get('f_time'),
                's_time' => $request->get('s_time'),
                'day' => $request->get('day'),
            );

            DB::beginTransaction();

            DoctorsClinicDetails::where('id', $request->id)->update($data_clinic);

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

    function ClinicDelete(Request $request)
    {
        try {

            DB::beginTransaction();

            //DoctorsClinicDetails::FindOrFail($request->id)->forceDelete();
            //where('clinic', 'like', '%' . $clinic_name . '%')
            DoctorsClinicDetails::where('clinic', $request->clinic_name)->where('doctor_id', $request->doctor_id)->forceDelete();

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

    function HospitalNew(Request $request)
    {
        $data = [];

        try {
            DB::beginTransaction();

            $doctor_id = $request->doctor_id;
            $hospital_id = $request->hospital_id;

            $check = DoctorsHospitalDetails::where('doctor_id', $doctor_id)->where('hospital_id', $hospital_id)->get();

            if ($check->count() > 0) {
                $data['status'] = false;
                $data['message'] = 'Same Hospital is already added under your profile please edit that instead of adding multiple';

                return response()->json($data);
            }

            $time_array = json_decode($request->time);
            $time_counter = count($time_array);

            for ($i = 0; $i < $time_counter; $i++) {

                $data_doc = array(

                    'doctor_id' => $doctor_id,
                    'hospital_id' => $hospital_id,
                    'f_time' => $time_array[$i]->f_time,
                    's_time' => $time_array[$i]->s_time,
                    'day' => $time_array[$i]->day

                );

                DoctorsHospitalDetails::insert($data_doc);
            }

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

    function HospitalEditNew(Request $request)
    {
        $data = [];

        try {
            DB::beginTransaction();

            $doctor_id = $request->doctor_id;
            $hospital_id = $request->hospital_id;

            DoctorsHospitalDetails::where('doctor_id', $doctor_id)->where('hospital_id', $hospital_id)->forceDelete();

            $time_array = json_decode($request->time);
            $time_counter = count($time_array);

            for ($i = 0; $i < $time_counter; $i++) {

                $data_doc = array(

                    'doctor_id' => $doctor_id,
                    'hospital_id' => $hospital_id,
                    'f_time' => $time_array[$i]->f_time,
                    's_time' => $time_array[$i]->s_time,
                    'day' => $time_array[$i]->day

                );

                DoctorsHospitalDetails::insert($data_doc);
            }


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

    function DoctorWiseHospitalNew(Request $request)
    {

        $DoctorHospitalList = [];
        $doc_id = '';
        $hos_id = '';

        $DoctorHospitalLists = DoctorsHospitalDetails::select('id', 'doctor_id', 'hospital_id', 'created_by')->with('get_hospital')->where('doctor_id', $request->doctor_id)->orderBy('id', 'asc')->get();
        //print_r($DoctorHospitalLists);exit();
        foreach ($DoctorHospitalLists as $row) {
            if ($doc_id != $row->doctor_id || $hos_id != $row->hospital_id) {

                $DoctorHospitalList[] = [
                    'id' => $row->id,
                    'doctor_id' => $row->doctor_id,
                    'hospital_id' => $row->hospital_id,
                    'created_by' => $row->created_by,
                    'time' => DoctorsHospitalDetails::select('f_time', 's_time', 'day')->where('doctor_id', $row->doctor_id)->where('hospital_id', $row->hospital_id)->orderBy('id', 'asc')->get(),
                    'get_hospital' => Hospital::where('id', $row->hospital_id)->first(),
                ];
            }

            $doc_id = $row->doctor_id;
            $hos_id = $row->hospital_id;
        }

        return response()->json(compact('DoctorHospitalList'));
    }

    function AddClinicNew(Request $request)
    {
        $data = [];

        try {
            DB::beginTransaction();

            $doctor_id = $request->doctor_id;
            $clinic_name = $request->clinic;
            $city = $request->city;
            $area = $request->area;
            $address = $request->address;
            $contact = $request->contact;

            $time_array = json_decode($request->time);
            $time_counter = count($time_array);

            for ($i = 0; $i < $time_counter; $i++) {

                $data_doc = array(
                    'doctor_id' => $doctor_id,
                    'clinic' => $clinic_name,
                    'city' => $city,
                    'area' => $area,
                    'address' => $address,
                    'contact' => $contact,
                    'f_time' => $time_array[$i]->f_time,
                    's_time' => $time_array[$i]->s_time,
                    'day' => $time_array[$i]->day
                );

                DoctorsClinicDetails::insert($data_doc);
            }


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

    function EditClinicNew(Request $request)
    {
        $data = [];

        try {
            DB::beginTransaction();

            $doctor_id = $request->doctor_id;
            $clinic_name = $request->clinic;
            $city = $request->city;
            $area = $request->area;
            $address = $request->address;
            $contact = $request->contact;

            DoctorsClinicDetails::where('doctor_id', $doctor_id)->where('clinic', 'like', '%' . $clinic_name . '%')->forceDelete();

            $time_array = json_decode($request->time);
            $time_counter = count($time_array);

            for ($i = 0; $i < $time_counter; $i++) {
                $data_doc = array(
                    'doctor_id' => $doctor_id,
                    'clinic' => $clinic_name,
                    'city' => $city,
                    'area' => $area,
                    'address' => $address,
                    'contact' => $contact,
                    'f_time' => $time_array[$i]->f_time,
                    's_time' => $time_array[$i]->s_time,
                    'day' => $time_array[$i]->day
                );

                DoctorsClinicDetails::insert($data_doc);
            }

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            //$msg = $e->getMessage();
            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function DoctorWiseClinicNew(Request $request)
    {
        $ClinicList = [];

        $doc_id = '';
        $clinic = '';

        $DoctorsClinicDetails = DoctorsClinicDetails::with('get_city', 'get_area')->select('id', 'doctor_id', 'contact', 'clinic', 'address', 'created_by', 'city', 'area')->with('get_city', 'get_area')->where('doctor_id', $request->doctor_id)->orderBy('id', 'asc')->get();

        foreach ($DoctorsClinicDetails as $row) {
            if ($doc_id != $row->doctor_id || $clinic != $row->clinic) {

                $ClinicList[] = [
                    'id' => $row->id,
                    'doctor_id' => $row->doctor_id,
                    'clinic' => $row->clinic,
                    'city' => $row->city,
                    'area' => $row->area,
                    'city_name' => $row->get_city ? $row->get_city->city_name : 'Not Found',
                    'area_name' => $row->get_area ? $row->get_area->area_name : 'Not Found',
                    'address' => $row->address,
                    'contact' => $row->contact,
                    'created_by' => $row->created_by,
                    'time' => DoctorsClinicDetails::select('f_time', 's_time', 'day')->where('doctor_id', $row->doctor_id)->where('clinic', 'like', '%' . $row->clinic . '%')->orderBy('id', 'asc')->get(),
                ];
            }

            $doc_id = $row->doctor_id;
            $clinic = $row->clinic;
        }

        return response()->json(compact('ClinicList'));
    }

    function GetPrescriptionCommentList(Request $request)
    {
        $pres_data = PatientPrescriptionDetails::where('created_by', $request->doc_id)->pluck('booking_id')->toArray();
        $review_data = PatientPrescriptionComments::with('get_patient')->whereIn('prescription_id', $pres_data)->get();
        return response()->json(compact('review_data'));
    }

    function get_doctor_about()
    {
        $user = Auth::user()->id;
        $data = DoctorsData::with('get_degree', 'get_speciality')->where('created_by', $user)->get()->first();
        return response()->json($data);
    }

    function GetPatientPrescriptionCommentList(Request $request)
    {
        $review_data = PatientPrescriptionComments::with('get_patient')->where('created_by', $request->patient_id)->get();
        return response()->json(compact('review_data'));
    }

    function ask_doc_comment(Request $request)
    {
        try {
            $Helpdata = [
                'comment' => $request->comment,
                'question_id' => $request->question_id,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $request->user_id,
            ];

            DB::beginTransaction();

            HealthQuestionReview::create($Helpdata);

            $data['status'] = true;
            $data['message'] = 'Success';

            DB::commit();

        } catch (Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();

            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);
    }

    function ask_doc_comment_list(Request $request)
    {
        $data = HealthQuestionReview::with('user')->where('question_id', $request->question_id)->get();
        return response()->json(compact('data'));
    }

    function change_online_status(Request $request)
    {
        $data_doc = array(
            'online' => $request->status
        );

        try {
            DB::beginTransaction();

            DoctorsData::where('created_by', $request->doc_id)->update($data_doc);

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

    function doc_online_list(Request $request)
    {
        $speciality_id = $request->speciality_id;

        $data = DoctorsData::with('get_photo')
            ->where('doctors_datas.online', 1);

        if ($speciality_id) {
            $data = $data->leftJoin('doctors_speciality_details', 'doctors_speciality_details.doctor_id', '=', 'doctors_datas.created_by')
                ->where('doctors_speciality_details.speciality_id', '=', $speciality_id);
        }

        $data = $data->get();
        return response()->json($data);
    }

    public function reportDoctor()
    {
        $user_id = Auth::user()->id;

        try {
            $data = TwilioVideo::join('twilio_video_logs', 'twilio_videos.id', '=', 'twilio_video_logs.twilio_video_id')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'twilio_video_logs.ParticipantIdentity');
                    $join->on('users.id', '!=', DB::raw("''"));
                })
                ->where('twilio_videos.recipientUserId', '=', $user_id)
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
}
