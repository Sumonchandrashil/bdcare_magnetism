<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorOffDaysDetails;
use App\Model\BDCare\DoctorsClinicDetails;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\DoctorsDegreeDetails;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\DoctorsSpecialityDetails;
use App\Model\BDCare\Notifications;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\PatientPrescriptionComments;
use App\Model\BDCare\PatientPrescriptionDetails;
use App\Model\BDCare\Setup\Area;
use App\Model\BDCare\Setup\City;
use App\Model\BDCare\Setup\degree;
use App\Model\BDCare\Setup\Hospital;
use App\Model\BDCare\Setup\medicine;
use App\Model\BDCare\Setup\speciality;
use App\Model\PackageService\HealthArticle;
use App\Model\PackageService\HelpCenter;
use App\Model\Twilio\TwilioVideo;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Mail;

class DoctorsProfileController extends Controller
{
    public function index()
    {
        $data['doc_data'] = DoctorsData::where('created_by', Auth::user()->id)
            ->get()
            ->first();
        $data['body'] = 'backend/doctor/profile';
        return view('backend/dashboard', $data);
    }

    function store(Request $request)
    {
        $dataDOc = DoctorsData::where('created_by', Auth::user()->id)->first();

        $data = array(

            'doctor_name' => $request->name,
            'email' => $request->email,
            'visiting_fees' => $request->visiting_fees,
            'emergency_contact' => $request->emergency_contact,
            'year_of_experience' => $request->year_of_experience,
            'bmdc_reg_no' => $request->bmdc_reg_no,
            'bmdc_reg_year' => $request->bmdc_reg_year,
            'current_designation' => $request->current_designation,
            'gender' => $request->gender,
            'address' => $request->address,
            'bio_data' => $request->bio_data,
            'age' => $request->age,
            'summary' => $request->summary,
        );

        try {
            DB::beginTransaction();

            $image = $request->file('bmdc_doc');
            $image_id = $request->file('passport_nid');

            $data['updated_by'] = Auth::user()->id;

            if ($image) {

                $imgName = md5(str_random(30) . time() . '_' . $request->file('bmdc_doc')) . '.' . $request->file('bmdc_doc')->getClientOriginalExtension();

                $request->file('bmdc_doc')->move('uploads/doctor_bmdc_doc/', $imgName);

                if (file_exists('uploads/doctor_bmdc_doc/' . $dataDOc->bmdc_doc) AND !empty($dataDOc->bmdc_doc)) {
                    unlink('uploads/doctor_bmdc_doc/' . $dataDOc->bmdc_doc);
                }
                $data['bmdc_doc'] = $imgName;
            }

            if ($image_id) {
                $imgName = md5(str_random(30) . time() . '_' . $request->file('passport_nid')) . '.' . $request->file('passport_nid')->getClientOriginalExtension();

                $request->file('passport_nid')->move('uploads/doctor_passport_nid/', $imgName);
                if (file_exists('uploads/doctor_passport_nid/' . $dataDOc->passport_nid) AND !empty($dataDOc->passport_nid)) {
                    unlink('uploads/doctor_passport_nid/' . $dataDOc->passport_nid);
                }
                $data['passport_nid'] = $imgName;
            }

            DoctorsData::where('created_by', Auth::user()->id)->update($data);

            DB::commit();
            return redirect(url('doctors_profile-backend'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('doctors_profile-backend'))->withInput()->with('errorMsg', $message);
        }
    }

    function appointment_booked()
    {
        $user = Auth::user()->id;

        $data['appointment_data'] = PatientAppointmentDetails::with('get_patient', 'get_hospital')
            ->where('doctor_id', $user)
            ->orderBy('patient_appointment_details.date', 'desc')
            ->get()/*->paginate(10)*/
        ;

        $data['medicines'] = medicine::where('status', 1)->orderBy('medicine_name', 'ASC')->get();

        $data['body'] = 'backend/doctor/booked_appointment';
        return view('backend/dashboard', $data);
    }

    function patient_booking_status_update($patient_id)
    {
        //$patient_id is row id

        try {
            DB::beginTransaction();

            $data['status'] = 1;

            PatientAppointmentDetails::where('id', $patient_id)->update($data);

            DB::commit();

            $info = PatientAppointmentDetails::with('get_hospital')->where('id', $patient_id)->get()->first();

            $Patient = $info->patient_id;

            $hospital_name = $info->get_hospital ? $info->get_hospital->hospital_name : '';

            $patient_name = PatientData::where('created_by', $Patient)->get()->first()->patient_name;

            $token = User::where('id', $Patient)->first() ? User::where('id', $Patient)->first()->token : '';

            $title = "Booking Confirmation";

            $msg = "Dear " . $patient_name . "your booking has been confirmed by the doctor at " . $hospital_name . " on " . date('d-M-y', strtotime($info->date)) . " at " . $info->schedule;

            $data_not = array(

                'title' => $title,
                'details' => $msg,
                'key_note' => 'appointment',
                'created_by' => Auth::user()->id,
                'created_for' => $Patient,
            );

            Notifications::insert($data_not);

            if ($token != '') {
                push_notification($title, $msg, $token);
            }


            return redirect(url('appointment-booked'))->withInput()->with('successMsg', "Data Updated Successfully for $patient_name.");
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            //return redirect(url('appointment-booked'))->withInput()->with('errorMsg','Something Went wrong');
            return redirect(url('appointment-booked'))->withInput()->with('errorMsg', $message);

        }
    }

    function prescription_data_update(Request $request)
    {
        $diagonosis = [];

        try {

            DB::beginTransaction();

            for ($i = 0; $i < count($request->medicine); $i++) {

                $diagonosis[$i]['dose'] = $request->morning[$i] . '+' . $request->noon[$i] . '+' . $request->night[$i];//dose
                //echo $request->night[$i];exit;
                if (isset($request->meal[$i])) {
                    $diagonosis[$i]['isBeforeMeal'] = 'true';//isBeforeMeal

                } else {

                    $diagonosis[$i]['isBeforeMeal'] = 'false';

                }

                $diagonosis[$i]['medicineId'] = $request->medicine[$i];//medicineId

                $diagonosis[$i]['medicineName'] = DB::table('medicines')->where('id', $request->medicine[$i])->first()->medicine_name;//medicineName

                $diagonosis[$i]['medicineType'] = $request->type[$i];//medicineType
            }

            //print_r($diagonosis);

            $diagonosis = json_encode($diagonosis);

            $data['history'] = $request->history;
            $data['diagonosis'] = $diagonosis;//$request->diagonosis;
            $data['description'] = $request->description;
            $data['tests'] = $request->tests;
            $data['recommendation'] = $request->recommendation;
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            PatientPrescriptionDetails::where('id', $request->row_id)->update($data);

            DB::commit();
            return redirect(url('appointment-booked'))->withInput()->with('successMsg', "Data Successfully Updated.");
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return redirect(url('appointment-booked'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }


    function getCreatePrescription()
    {

        $data['medicines'] = medicine::where('status', 1)->orderBy('medicine_name', 'ASC')->get();

        $data['body'] = 'backend/doctor/create_prescription';
        return view('backend/dashboard', $data);
    }


    function prescription_data_insert(Request $request)
    {
        $diagonosis = [];

        //print_r($request->medicine);exit();
        //echo count($request->medicine);
        //print_r($request->noon);
        //exit();
        try {
            DB::beginTransaction();

            for ($i = 0; $i < count($request->medicine); $i++) {
                //echo $request->noon[$i];exit;
                $diagonosis[$i]['dose'] = $request->morning[$i] . '+' . $request->noon[$i] . '+' . $request->night[$i];//dose

                if (isset($request->meal[$i])) {
                    $diagonosis[$i]['isBeforeMeal'] = 'true';//isBeforeMeal

                } else {

                    $diagonosis[$i]['isBeforeMeal'] = 'false';

                }

                $diagonosis[$i]['medicineId'] = $request->medicine[$i];//medicineId

                $diagonosis[$i]['medicineName'] = DB::table('medicines')->where('id', $request->medicine[$i])->first()->medicine_name;//medicineName

                $diagonosis[$i]['medicineType'] = $request->type[$i];//medicineType
            }

            //print_r($diagonosis);

            $diagonosis = json_encode($diagonosis);


            $data['booking_id'] = $request->row_id;
            $data['patient_id'] = $request->patient_id;
            $data['history'] = $request->history;

            $data['diagonosis'] = $diagonosis;//$request->diagonosis;

            $data['description'] = $request->description;
            $data['tests'] = $request->tests;
            $data['recommendation'] = $request->recommendation;
            $data['created_by'] = Auth::user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');

            PatientPrescriptionDetails::insert($data);

            $data2['status'] = 2;

            PatientAppointmentDetails::where('id', $request->row_id)->update($data2);

            DB::commit();
            return redirect(url('appointment-booked'))->withInput()->with('successMsg', "Data Inserted Successfully for.");
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('appointment-booked'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function DoctorDegree()
    {
        $user = Auth::user()->id;

        $data['doc_data'] = DoctorsDegreeDetails::with('get_degree')->where('doctor_id', $user)->orderBy('id', 'desc')->get();
        $data['degreesss'] = degree::get();

        $data['body'] = 'backend/doctor/DegreeDetails';
        return view('backend/dashboard', $data);
    }

    function AddDegree(Request $request)
    {
        $data = array(

            'doctor_id' => Auth::user()->id,
            'degree_id' => $request->degree,
            'institute' => $request->institute,
            'passing_year' => $request->passing_year,
        );

        try {
            DB::beginTransaction();

            DoctorsDegreeDetails::insert($data);

            DB::commit();
            return redirect(url('DoctorDegree'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return redirect(url('DoctorDegree'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function DoctorSpeciality()
    {
        $user = Auth::user()->id;

        $data['doc_data'] = DoctorsSpecialityDetails::with('get_speciality')->where('doctor_id', $user)->orderBy('id', 'desc')->get();
        $data['speciality'] = speciality::orderBy('speciality_name', 'ASC')->get();
        $data['body'] = 'backend/doctor/SpecialityDetails';
        return view('backend/dashboard', $data);
    }

    function AddSpeciality(Request $request)
    {
        $data = array(

            'doctor_id' => Auth::user()->id,
            'speciality_id' => $request->speciality,
            'remarks' => $request->remarks,
        );

        try {
            DB::beginTransaction();

            DoctorsSpecialityDetails::insert($data);

            DB::commit();
            return redirect(url('DoctorSpeciality'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return redirect(url('DoctorSpeciality'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function DoctorHospitalDetail()
    {
        $user = Auth::user()->id;
        $data['hospital'] = Hospital::orderBy('hospital_name', 'ASC')->get();
        $data['doc_data'] = DoctorsHospitalDetails::where('doctor_id', $user)->orderBy('id', 'desc')->get();
        $data['body'] = 'backend/doctor/HospitalDetails';
        return view('backend/dashboard', $data);
    }

    function DoctorClinicDetail()
    {
        $user = Auth::user()->id;

        $data['doc_data'] = DoctorsClinicDetails::where('doctor_id', $user)->orderBy('id', 'desc')->get();
        $data['cities'] = City::where('status', 1)->orderBy('city_name', 'ASC')->get();
        $data['areas'] = Area::where('status', 1)->orderBy('area_name', 'ASC')->get();
        $data['body'] = 'backend/doctor/ClinicDetails';
        return view('backend/dashboard', $data);
    }

    function AddHospitalData(Request $request)
    {
        for ($i = 0; $i < count($request->day); $i++) {
            $data[] = array(

                'doctor_id' => Auth::user()->id,
                'hospital_id' => $request->hospital,
                'f_time' => date('H:i:s', strtotime($request->f_time[$i])),
                's_time' => date('H:i:s', strtotime($request->s_time[$i])),
                'day' => $request->day[$i]
            );
        }


        try {
            DB::beginTransaction();

            DoctorsHospitalDetails::insert($data);

            DB::commit();
            return redirect(url('DoctorHospitalDetail'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return redirect(url('DoctorHospitalDetail'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function AddClinicData(Request $request)
    {
        for ($i = 0; $i < count($request->day); $i++) {
            $data[] = array(

                'doctor_id' => Auth::user()->id,
                'clinic' => $request->clinic,
                'city' => $request->city,
                'area' => $request->area,
                'address' => $request->address,
                'contact' => $request->contact,
                'f_time' => date('H:i:s', strtotime($request->f_time[$i])),
                's_time' => date('H:i:s', strtotime($request->s_time[$i])),
                'day' => $request->day[$i]
            );
        }


        try {
            DB::beginTransaction();

            DoctorsClinicDetails::insert($data);

            DB::commit();
            return redirect(url('DoctorClinicDetail'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return redirect(url('DoctorClinicDetail'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function getData(Request $request)
    {
        $data = PatientPrescriptionDetails::where('id', $request->row_id)->get()->first();

        return json_encode($data);
    }

    function getDataForEditPrescription(Request $request)
    {

        $data = PatientPrescriptionDetails::where('booking_id', $request->row_id)->get()->first();
        $medicines = medicine::orderBy('medicine_name', 'ASC')->get();
        //echo $data->id;exit();
        ?>

        <input type="hidden" name="row_id" id="row_id2" value="<?= $data->id; ?>">

        <h5 align="right"><b>Date:</b> <?= date('d-M-y') ?></h5>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputCity">Findings</label>
                <textarea type="text" class="form-control" name="history" id="history2"
                          placeholder="History"><?= $data->history; ?></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputCity">Medication</label>

                <table class="table table-bordered" id="re_table2">
                    <thead>
                    <tr>
                        <th>Medicine</th>
                        <th style="text-align: center">Type</th>
                        <th style="text-align: center">Dose</th>
                        <th style="text-align: center">Before Meal</th>

                        <th style="text-align: center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $data_med = json_decode($data->diagonosis);
                    $kt = 0;
                    foreach ($data_med as $medi_dt) {
                        ?>
                        <tr>
                            <td>
                                <select class="form-control select2 search" name="medicine[]" id="medicine<?= $kt; ?>"
                                        required style="width: 100%">
                                    <?php foreach ($medicines as $medicine) { ?>
                                        <option
                                            value="<?= $medicine->id ?>" <?php if ($medi_dt->medicineId == $medicine->id) { ?> selected<?php } ?>><?= $medicine->medicine_name; ?></option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td align="center">
                                <select name="type[]">
                                    <option
                                        value="cap" <?php if ($medi_dt->medicineType == "cap") { ?> selected <?php } ?>>
                                        Cap
                                    </option>
                                    <option
                                        value="sirup" <?php if ($medi_dt->medicineType == "sirup") { ?> selected <?php } ?>>
                                        Sirup
                                    </option>
                                    <option
                                        value="tablet" <?php if ($medi_dt->medicineType == "tablet") { ?> selected <?php } ?>>
                                        Tablet
                                    </option>
                                </select>
                            </td>

                            <td>
                                <input type="number" name="morning[]" placeholder="Morning" style="width: 30%"
                                       value="<?= substr($medi_dt->dose, 0, 1); ?>">
                                <input type="number" name="noon[]" placeholder="Noon" style="width: 30%"
                                       value="<?= substr($medi_dt->dose, 2, 1); ?>">
                                <input type="number" name="night[]" placeholder="Night" style="width: 30%"
                                       value="<?= substr($medi_dt->dose, 4, 1); ?>">
                            </td>

                            <td align="center"><input type="checkbox" name="meal[]"
                                                      class="" <?php if ($medi_dt->isBeforeMeal == 'true') { ?> checked <?php } ?>>
                            </td>

                            <td align="center"><a href="#" onclick="add_row2()"><i class="fa fa-plus"
                                                                                   aria-hidden="true"></i></a></td>
                        </tr>
                        <?php $kt++;
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputCity">Tests/Suggested Diagonosis</label>
                <textarea type="text" class="form-control" name="tests" id="tests2"
                          placeholder="Tests"><?= $data->tests; ?></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputCity">Recommendation</label>
                <textarea type="text" class="form-control" name="recommendation" id="recommendation2"
                          placeholder="Recommendation"><?= $data->recommendation; ?></textarea>
            </div>
        </div>

        <div class="form-row" style="display: none">
            <div class="form-group col-md-12">
                <label for="inputCity">Description</label>
                <textarea type="text" class="form-control" name="description" id="description2"
                          placeholder="Description"><?= $data->description; ?></textarea>
            </div>
        </div>


        <?php
    }

    function DeleteDegree($id)
    {


        try {
            DB::beginTransaction();

            DoctorsDegreeDetails::FindOrFail($id)->delete();

            DB::commit();

            return redirect(url('DoctorDegree'))->withInput()->with('successMsg', 'Data Successfully Deleted.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('DoctorDegree'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function DeleteSpeciality($id)
    {


        try {
            DB::beginTransaction();

            DoctorsSpecialityDetails::FindOrFail($id)->delete();

            DB::commit();

            return redirect(url('DoctorSpeciality'))->withInput()->with('successMsg', 'Data Successfully Deleted.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('DoctorSpeciality'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function DeleteHospitalDetails($id)
    {


        try {
            DB::beginTransaction();

            DoctorsHospitalDetails::FindOrFail($id)->delete();

            DB::commit();

            return redirect(url('DoctorHospitalDetail'))->withInput()->with('successMsg', 'Data Successfully Deleted.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('DoctorHospitalDetail'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function DeleteClinicDetails($id)
    {


        try {
            DB::beginTransaction();

            DoctorsClinicDetails::FindOrFail($id)->delete();

            DB::commit();

            return redirect(url('DoctorClinicDetail'))->withInput()->with('successMsg', 'Data Successfully Deleted.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('DoctorClinicDetail'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function getDataSpeciality(Request $request)
    {
        $data = DoctorsSpecialityDetails::FindOrFail($request->row_id);

        return json_encode($data);
    }

    function EditSpeciality(Request $request)
    {

        $data = array(
            'speciality_id' => $request->speciality2,
            'remarks' => $request->remarks2,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        try {
            DB::beginTransaction();

            DoctorsSpecialityDetails::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('DoctorSpeciality'))->withInput()->with('successMsg', 'Data Successfully Updated.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('DoctorSpeciality'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function getDataDegree(Request $request)
    {
        $data = DoctorsDegreeDetails::FindOrFail($request->row_id);

        return json_encode($data);
    }

    function EditDegree(Request $request)
    {

        $data = array(
            'degree_id' => $request->degree2,
            'institute' => $request->institute2,
            'passing_year' => $request->passing_year2,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        try {
            DB::beginTransaction();

            DoctorsDegreeDetails::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('DoctorDegree'))->withInput()->with('successMsg', 'Data Successfully Updated.');

        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return redirect(url('DoctorDegree'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function getDataHospital(Request $request)
    {
        $data = DoctorsHospitalDetails::FindOrFail($request->row_id);

        return json_encode($data);
    }

    function getDataClinic(Request $request)
    {
        $data = DoctorsClinicDetails::FindOrFail($request->row_id);

        return json_encode($data);
    }

    function EditHospital(Request $request)
    {

        $data = array(
            'hospital_id' => $request->hospital2,
            'f_time' => $request->f_time2,
            's_time' => $request->s_time2,
            'day' => $request->day2,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        try {
            DB::beginTransaction();

            DoctorsHospitalDetails::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('DoctorHospitalDetail'))->withInput()->with('successMsg', 'Data Successfully Updated.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('DoctorHospitalDetail'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function EditClinic(Request $request)
    {

        $data = array(
            'clinic' => $request->clinic2,
            'city' => $request->city2,
            'area' => $request->area2,
            'address' => $request->address2,
            'contact' => $request->contact2,
            'f_time' => $request->f_time2,
            's_time' => $request->s_time2,
            'day' => $request->day2,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        try {
            DB::beginTransaction();

            DoctorsClinicDetails::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('DoctorClinicDetail'))->withInput()->with('successMsg', 'Data Successfully Updated.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('DoctorClinicDetail'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function AddHealthArticle()
    {
        $user = Auth::user()->id;

        $data['doc_data'] = HealthArticle::where('created_by', $user)->orderBy('id', 'desc')->get();
        $data['body'] = 'backend/doctor/health_article';
        return view('backend/dashboard', $data);
    }

    function StoreArticle(Request $request)
    {

        $dataDOc = DoctorsData::where('created_by', Auth::user()->id)->first();

        $title = $request->title;
        $details = $request->description;

        $data = [
            'title' => $title,
            'description' => $details,
            'created_by' => Auth::user()->id,
            'date' => date('Y-m-d'),
        ];


        $image = $request->file('photo');

        if ($image) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();

            $originalImage = $request->file('photo');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path() . '/uploads/health_article/thumb/';
            $originalPath = public_path() . '/uploads/health_article/';
            $thumbnailImage->save($originalPath . $imgName);
            $thumbnailImage->resize(370, 288);
            $thumbnailImage->save($thumbnailPath . $imgName);


            if (file_exists('uploads/health_article/' . $dataDOc->image) AND !empty($dataDOc->image)) {
                unlink('uploads/health_article/' . $dataDOc->image);
                unlink('uploads/health_article/thumb/' . $dataDOc->image);
            }
            $data['image'] = $imgName;
        }


        HealthArticle::insert($data);

        try {
            DB::beginTransaction();


            DB::commit();
            return redirect(url('add-health-article'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            //print_r($message);
            return redirect(url('add-health-article'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function DeleteHealthArticle($id)
    {
        try {
            DB::beginTransaction();

            HealthArticle::FindOrFail($id)->delete();

            DB::commit();

            return redirect(url('add-health-article'))->withInput()->with('successMsg', 'Data Successfully Deleted.');

        } catch (Exception $e) {

            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('add-health-article'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function getDataHealthArticle(Request $request)
    {
        $data = HealthArticle::FindOrFail($request->row_id);

        return json_encode($data);
    }

    function EditHealthArticle(Request $request)
    {
        $dataDOc = DoctorsData::where('created_by', Auth::user()->id)->first();


        $data = array(
            'title' => $request->title2,
            'description' => $request->description2,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        );

        try {
            DB::beginTransaction();

            $image = $request->file('photo2');

            if ($image) {
                $imgName = md5(str_random(30) . time() . '_' . $request->file('photo2')) . '.' . $request->file('photo2')->getClientOriginalExtension();

                //$request->file('photo2')->move('uploads/health_article/',$imgName);

                $originalImage = $request->file('photo2');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = public_path() . '/uploads/health_article/thumb/';
                $originalPath = public_path() . '/uploads/health_article/';
                $thumbnailImage->save($originalPath . $imgName);
                $thumbnailImage->resize(370, 288);
                $thumbnailImage->save($thumbnailPath . $imgName);

                if (file_exists('uploads/health_article/' . $dataDOc->image) AND !empty($dataDOc->image)) {
                    unlink('uploads/health_article/' . $dataDOc->image);
                    unlink('uploads/health_article/thumb/' . $dataDOc->image);
                }
                $data['image'] = $imgName;
            }

            HealthArticle::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('add-health-article'))->withInput()->with('successMsg', 'Data Successfully Updated.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('add-health-article'))->withInput()->with('errorMsg', $message);
        }
    }

    function getDoctorOffDays()
    {
        $user = Auth::user()->id;
        $data['doc_off_day_data'] = DoctorOffDaysDetails::where('created_by', $user)->orderBy('doctor_off_day', 'desc')->get();
        $data['body'] = 'backend/doctor/doctor_off_days';
        return view('backend/dashboard', $data);
    }

    function getDoctorFeedback()
    {
        $user = Auth::user()->id;
        $pres_data = PatientPrescriptionDetails::where('created_by', $user)->pluck('booking_id')->toArray();
        $data['doc_feedback_data'] = PatientPrescriptionComments::with('get_patient')
            ->whereIn('prescription_id', $pres_data)
            ->orderBy('created_at', 'desc')
            ->get();
        $data['body'] = 'backend/doctor/doctor_feedback';

//        dd($data['doc_feedback_data']);

        return view('backend/dashboard', $data);
    }

    function AddDoctorOffDays(Request $request)
    {
        $data = [
            'doctor_id' => Auth::user()->id,
            'doctor_off_day' => $request->doctor_off_day,
            'created_by' => Auth::user()->id,
        ];
        try {
            DB::beginTransaction();

            DoctorOffDaysDetails::insert($data);

            DB::commit();
            return redirect(url('doctor-off-days'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect(url('doctor-off-days'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }


    function editDoctorOffDays(Request $request)
    {
        $data = DoctorOffDaysDetails::FindOrFail($request->row_id);
        return json_encode($data);
    }

    function UpdateDoctorOffDays(Request $request)
    {
        $data = array(
            'doctor_id' => Auth::user()->id,
            'doctor_off_day' => $request->doctor_off_day,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        );

        try {
            DB::beginTransaction();

            DoctorOffDaysDetails::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('doctor-off-days'))->withInput()->with('successMsg', 'Data Successfully Updated.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('doctor-off-days'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function deleteDoctorOffDays($id)
    {
        try {
            DB::beginTransaction();

            DoctorOffDaysDetails::FindOrFail($id)->delete();

            DB::commit();
            return redirect(url('doctor-off-days'))->withInput()->with('successMsg', 'Data Successfully Deleted.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('doctor-off-days'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function OnlineConsult()
    {
        $data['datas'] = HelpCenter::where('status', 2)->get();
        $data['body'] = 'backend/doctor/consult_data';
        return view('backend/dashboard', $data);
    }

    function ReplyOnlineConsult(Request $request)
    {
        $data['reply'] = $request->reply;
        $data['updated_by'] = Auth::user()->id;
        $email = HelpCenter::where('id', $request->row_id)->first()->email;

        try {
            DB::beginTransaction();

            HelpCenter::where('id', $request->row_id)->update($data);

            mail($email, 'Health Issue Reply', $data['reply']);

            DB::commit();

            return redirect(url('OnlineConsult'))->withInput()->with('successMsg', 'Data Successfully Updated.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            //print_r($message);
            return redirect(url('OnlineConsult'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function about()
    {
        $user = Auth::user()->id;
        $data['doc_data_info'] = DoctorsData::with('get_degree', 'get_speciality')->where('created_by', $user)->get()->first();
        $data['body'] = 'backend/doctor/about';
        return view('backend/dashboard', $data);
    }

    public function reportDoctor()
    {
        $user_id = Auth::user()->id;

        try {
            $videoList = TwilioVideo::join('twilio_video_logs', 'twilio_videos.id', '=', 'twilio_video_logs.twilio_video_id')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'twilio_video_logs.ParticipantIdentity');
                    $join->on('users.id', '!=', DB::raw("''"));
                })
                ->where('twilio_videos.recipientUserId', '=', $user_id)
                ->select([
                    'twilio_video_logs.id',
                    'users.user_name as ParticipantName',
                    'twilio_video_logs.twilio_video_id',
                    'twilio_video_logs.SequenceNumber',
                    'twilio_video_logs.ParticipantStatus',
                    'twilio_video_logs.ParticipantIdentity',
                    'twilio_video_logs.StatusCallbackEvent',
                    'twilio_video_logs.TrackKind',
                    'twilio_video_logs.ParticipantDuration',
                    'twilio_video_logs.RawData',
                    'twilio_video_logs.created_at as date'
                ])
                ->get();
            $data['datas'] = $videoList;
        } catch (Exception $e) {
            $data['datas'] = [];
        }
        $data['body'] = 'backend/doctor/report_doctor';
        return view('backend/dashboard', $data);
    }
}
