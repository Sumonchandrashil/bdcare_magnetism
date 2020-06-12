<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\DoctorsHospitalDetails;
use App\Model\BDCare\DoctorsSpecialityDetails;
use App\Model\BDCare\Notifications;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\PatientMedicalRecord;
use App\Model\BDCare\PatientMedication;
use App\Model\BDCare\PatientPrescriptionComments;
use App\Model\BDCare\PatientPrescriptionDetails;
use App\Model\BDCare\Setup\Area;
use App\Model\BDCare\Setup\City;
use App\Model\BDCare\Setup\Hospital;
use App\Model\BDCare\Setup\medicine;
use App\Model\BDCare\Setup\Speciality;
use App\Model\PackageService\BookedPackage;
use App\Model\PackageService\BookedService;
use App\Model\Twilio\TwilioVideo;
use App\User;
use DB;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use Validator;
use View;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->appointment_schedule = appointment_schedule();
    }

    function patient_info()
    {
        $user = Auth::user()->id;

        $data['patient_data'] = PatientData::where('created_by', $user)->get()->first();
        $data['body'] = 'backend/patient/profile';
        return view('backend/dashboard', $data);
    }

    function store(Request $request)
    {
        $validator = $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'age' => 'required',
        ]);

        $data = array(

            'patient_name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'occupation' => $request->occupation,
            'address' => $request->address,
            'gender' => $request->gender,
            'age' => $request->age,
            'details' => $request->details
        );

        try {
            DB::beginTransaction();

            PatientData::where('created_by', $user = Auth::user()->id)->update($data);

            DB::commit();
            return redirect(url('patient_info'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            //$message = $e->getMessage();
            return redirect(url('patient_info'))->withInput()->with('errorMsg', 'Something Went wrong');
            /*return response()->json(['status' => 'error', 'message' => ]);*/
        }
    }

    function AppointBooking()
    {
        $user = Auth::user()->id;

        $data['city'] = City::get();
        $data['area'] = Area::get();
        $data['hospital'] = Hospital::get();
        $data['doctors'] = DoctorsData::get();

        $data['patient_data'] = PatientAppointmentDetails::where('patient_id', $user)->orderBy('date', 'desc')->get();

        $data['body'] = 'backend/patient/appointment_booking';
        return view('backend/dashboard', $data);
    }

    function regular_medication()
    {
        $user = Auth::user()->id;

        $data['patient_data'] = PatientMedication::with('get_medicine')->where('created_by', $user)->orderBy('id', 'desc')->get();
        $data['body'] = 'backend/patient/regular_medication';
        $data['medicines'] = medicine::where('status', 1)->get();
        return view('backend/dashboard', $data);
    }

    function add_medication(Request $request)
    {
        $validator = $this->validate($request, [
            'medication_name' => 'required|string',
        ]);

        //return redirect(url('regular-medication'))->withInput()->with('successMsg','Data Inserted Successfully.');

        $data = array(
            'medication_name' => $request->medication_name,
            'description' => $request->detail,
            'created_by' => Auth::user()->id,
            'status' => $request->status
        );

        try {
            DB::beginTransaction();

            PatientMedication::insert($data);

            DB::commit();

            return redirect(url('regular-medication'))->withInput()->with('successMsg', 'Data Inserted Successfully.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('regular-medication'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function bookAppointment(Request $request)
    {
        $validator = $this->validate($request, [
            'hospital' => 'required',
            'doctor' => 'required',
            'schedule' => 'required',
        ]);

        $schedule = date('H:i:s', strtotime($request->schedule));

        $data = array(

            'patient_id' => Auth::user()->id,
            'doctor_id' => $request->doctor,
            'hospital_id' => $request->hospital,
            'schedule' => date('H:i:s', strtotime($request->schedule)),
            'day' => $request->day,
            'date' => $request->date,
            'created_by' => Auth::user()->id,
            'created_at' => dateConvertDBtoForm($request->date),//date('Y-m-d H:i:s')
        );

        $check_appointment = PatientAppointmentDetails::where('doctor_id', $request->doctor)->where('hospital_id', $request->hospital)->where('schedule', $schedule)->where('day', $request->day)->where('date', $request->date)->count();

        if ($check_appointment > 0) {
            $message = 'Schedule Already Booked Please Select Another Schedule';
            return redirect(url('appointment-booking'))->withInput()->with('errorMsg', $message);
        }

        try {
            DB::beginTransaction();

            PatientAppointmentDetails::insert($data);

            DB::commit();

            $doctor_name = DoctorsData::where('created_by', $request->doctor)->first() ? DoctorsData::where('created_by', $request->doctor)->first()->doctor_name : '';
            $patient_name = PatientData::where('created_by', Auth::user()->id)->first() ? PatientData::where('created_by', Auth::user()->id)->first()->patient_name : '';
            $hospital_name = Hospital::where('id', $request->hospital)->first() ? Hospital::where('id', $request->hospital)->first()->hospital_name : '';
            $time = date("d-M-y", strtotime($request->date)) . '>' . date('H:i:s A', strtotime($request->schedule));
            $msg = 'Dear Doctor ' . $doctor_name . ' one patient named ' . $patient_name . ' want to have a booking at ' . $hospital_name . ' on ' . $time;
            $token = User::where('id', $request->doctor)->first() ? User::where('id', $request->doctor)->first()->token : '';//"d8FTrbC1Srk:APA91bGgjyqE1fEX1hCsbxcC66oA0q7HfDX6ykgoFif43-0vgvfh9uTY0szvDNFtIrfZed0Zm3Es3pu1JyR-dag0YA5i8nIVwuR_NGQBF4_NFeKhz9v0BawboIIFfX49xTkM_AtlX8J_";
            $title = 'Booking Request';

            $data_not = array(

                'title' => $title,
                'details' => $msg,
                'key_note' => 'Booking Request',
                'created_by' => Auth::user()->id,
                'created_for' => $request->doctor,
            );

            Notifications::insert($data_not);

            if ($token != '') {
                push_notification($title, $msg, $token);
            }

            return redirect(url('appointment-booking'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('appointment-booking'))->withInput()->with('errorMsg', $message);
        }
    }

    function UserProfile()
    {
        $user = Auth::user()->id;

        $data['user_data'] = DB::table('users')->where('id', $user)->get()->first();
        $data['body'] = 'backend/UserProfile';
        return view('backend/dashboard', $data);
    }

    function UserProfileStore(Request $request)
    {
        $data = User::findOrFail($request->id);

        $input = $request->all();

        //echo $input['mobile'];exit;
        if ($input['password'] != $input['password_confirmation']) {
            return redirect()->back()->with('errorMsg', 'Password Not Matched');
        } elseif ($input['password'] == $input['password_confirmation'] && $input['password'] != '') {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $data->password;
        }

        $image = $request->file('user_photo');
        $input['created_by'] = Auth::user()->id;
        $input['modified_by'] = Auth::user()->id;

        if ($image) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('user_photo')) . '.' . $request->file('user_photo')->getClientOriginalExtension();

            $request->file('user_photo')->move('uploads/user_photo/', $imgName);
            if (file_exists('uploads/user_photo/' . $data->photo) AND !empty($data->photo)) {
                unlink('uploads/user_photo/' . $data->photo);
            }
            $input['user_photo'] = $imgName;
        }

        try {
            unset($input['_token']);
            unset($input['password_confirmation']);

            User::where('id', $input['id'])->update($input);

            $bug = 0;
        } catch (Exception $e) {
            $bug = $e->errorInfo[1];
        }
        if ($bug == 0) {
            return redirect('UserProfile')->with('successMsg', 'User Updated Successfully.');
        } elseif ($bug == 1062) {
            return redirect('UserProfile')->with('errorMsg', 'User is Found Duplicate');
        } else {
            $msg = $e->getMessage();
            return redirect()->back()->with('errorMsg', 'Something Went Wrong');
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
        $mpdf->WriteHTML($html);
        $mpdf->Output("BDCare_Prescription_$bookingID.pdf", 'I');
    }

    function view_prescription_pdf(Request $request)
    {
        try {
            $bookingID = $request->prescription_id;

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
            $mpdf->WriteHTML($html);
            //$mpdf->Output("BDCare_Prescription_$bookingID.pdf",'I');
            $mpdf->Output("uploads/prescription/BDCare_Prescription_$bookingID.pdf", 'F');

            $data['status'] = true;
            $data['message'] = 'Success';
            $data['url'] = url("/uploads/prescription/BDCare_Prescription_$bookingID.pdf");
        } catch (Exception $e) {
            $data['status'] = false;
            $data['message'] = 'Failed';
            $data['url'] = '';
        }
        return response()->json($data);
    }

    function getMedication(Request $request)
    {
        $data = PatientMedication::where('id', $request->row_id)->get()->first();

        return json_encode($data);
    }

    function UpdateMedication(Request $request)
    {
        /* $validator = $this->validate($request, [
             'medication_name' => 'required|string|unique:patient_medications',
         ]);*/
        if ($request->status2 == 'on') {
            $status = 1;

        } elseif ($request->status2 == null) {
            $status = 0;
        }
        $data = array(
            'medication_name' => $request->medication_name2,
            'description' => $request->detail2,
            'updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => $status
        );

        try {
            DB::beginTransaction();

            PatientMedication::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('regular-medication'))->withInput()->with('successMsg', 'Data Successfully Updated.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('regular-medication'))->withInput()->with('errorMsg', $message);
        }
    }

    function DeleteMedication($id)
    {
        try {
            DB::beginTransaction();

            PatientMedication::where('id', $id)->delete();

            DB::commit();

            return redirect(url('regular-medication'))->withInput()->with('successMsg', 'Data Successfully Deleted.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('regular-medication'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function DeleteAppointment($id)
    {
        try {
            DB::beginTransaction();

            PatientAppointmentDetails::where('id', $id)->delete();

            DB::commit();

            return redirect(url('appointment-booking'))->withInput()->with('successMsg', 'Data Successfully Deleted.');

        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('appointment-booking'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function GetDocData(Request $request)
    {
        $city_id = $request->city_id;

        $Hospitals = Hospital::select('id', 'hospital_name')->where('city', $city_id)->get();

        /*$Doctors = DoctorsHospitalDetails::select('doctor_id')->whereIn('hospital_id',$Hospitals)->get()->toArray();

        $filterDocData = DoctorsData::whereIn('created_by',$Doctors)->get();*/

        ?>
        <select class="form-control select2 search" name="hospital" id="hospital" onchange="filter_doc3();"
                style="width: 100%">
            <option value="">Select Hospital</option>
            <?php
            foreach ($Hospitals as $rowData) {
                ?>
                <option value="<?= $rowData->id; ?>"><?= $rowData->hospital_name; ?></option>
            <?php }
            ?>
        </select>
        <?php
    }

    function GetDocData2(Request $request)
    {
        $city_id = $request->city_id;
        $area_id = $request->area_id;

        $Hospitals = Hospital::select('id', 'hospital_name')->where('city', $city_id)->where('area', $area_id)->get();

        /*$Doctors = DoctorsHospitalDetails::select('doctor_id')->whereIn('hospital_id',$Hospitals)->get()->toArray();

        $filterDocData = DoctorsData::whereIn('created_by',$Doctors)->get();*/

        ?>
        <select class="form-control select2 search" name="hospital" id="hospital" onchange="filter_doc3();"
                style="width: 100%">
            <option value="">Select Hospital</option>
            <?php
            foreach ($Hospitals as $rowData) {
                ?>
                <option value="<?= $rowData->id; ?>"><?= $rowData->hospital_name; ?></option>
            <?php }
            ?>
        </select>
        <?php
    }

    function GetDocData3(Request $request)
    {
        $city_id = $request->city_id;
        $area_id = $request->area_id;
        $hospital_id = $request->hospital_id;

        //$Hospitals = Hospital::select('id')->where('id',$hospital_id)->get()->toArray();

        $Doctors = DoctorsHospitalDetails::select('doctor_id')->where('hospital_id', $hospital_id)->get()->toArray();

        $filterDocData = DoctorsData::whereIn('created_by', $Doctors)->get();

        ?>
        <select class="form-control select2 search" name="doctor" id="doctor" onchange="filter_day();"
                style="width: 100%">
            <option value="">Select Doctor</option>
            <?php
            foreach ($filterDocData as $rowData) {
                ?>
                <option value="<?= $rowData->created_by; ?>"><?= $rowData->doctor_name; ?></option>
            <?php }
            ?>
        </select>
        <?php
    }

    function GetDocDay(Request $request)
    {
        $doc_id = $request->doc_id;
        $hospital_id = $request->hospital_id;

        $day = DoctorsHospitalDetails::where('hospital_id', $hospital_id)->where('doctor_id', $doc_id)->get();

        ?>

        <select class="form-control select2 search" id="day" name="day" onchange="filter_schedule();"
                style="width: 100%">
            <option value="">Select Day</option>
            <?php foreach ($day as $each_day) { ?>
                <option value="<?= $each_day->day; ?>"><?= $each_day->day; ?></option>
            <?php } ?>
        </select>
        <?php
    }

    function GetDocSchedule(Request $request)
    {
        $doc_id = $request->doc_id;
        $hospital_id = $request->hospital_id;
        $day = $request->day;

        $schedule = DoctorsHospitalDetails::where('day', $day)->where('hospital_id', $hospital_id)->where('doctor_id', $doc_id)->get()->first();

        $f_time = $schedule->f_time;
        $s_time = $schedule->s_time;

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
        ?>

        <select class="form-control select2 search" id="schedule" name="schedule" style="width: 100%">
            <?php
            for ($i = 1; $i <= $loop_length; $i++) {
                ?>
                <option value="<?php

                if ($i == 1) {
                    echo $start_time = date("H:i", strtotime('+0 minutes', $f_time));
                } else {
                    echo $start_time = date("H:i", strtotime("+$this->appointment_schedule minutes", $f_time));
                }

                ?>">
                    <?php

                    if ($i == 1) {
                        echo $start_time = date("H:i", strtotime('+0 minutes', $f_time));
                    } else {
                        echo $start_time = date("H:i", strtotime("+$this->appointment_schedule minutes", $f_time));
                    }

                    $f_time = strtotime($start_time);

                    ?>

                </option>
                <?php
            }

            ?>

        </select>

        <!--<div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Day</label>
                <input class="form-control" readonly id="day" name="day" value="<?/*=$schedule->day;*/ ?>">
            </div>
        </div>-->
        <?php
    }

    function medical_records()
    {
        $user = Auth::user()->id;

        $data['data'] = PatientMedicalRecord::where('created_by', $user)->orderBy('id', 'desc')->get();
        $data['body'] = 'backend/patient/medical_records';
        return view('backend/dashboard', $data);
    }

    function AddMedicalRecord(Request $request)
    {
        $title = $request->title;

        $data = [
            'title' => $title,
            'created_by' => Auth::user()->id,
        ];

        try {
            DB::beginTransaction();

            $image = $request->file('photo');

            if ($image) {
                $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();

                $request->file('photo')->move('uploads/medical_records/', $imgName);

                $data['image'] = $imgName;
            }

            PatientMedicalRecord::create($data);

            DB::commit();
            return redirect(url('medical-records'))->withInput()->with('successMsg', 'Data Inserted Successfully.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('medical-records'))->withInput()->with('errorMsg', $message);
        }
    }

    function EditMedicalRecord(Request $request)
    {
        $dataDOc = PatientMedicalRecord::where('created_by', Auth::user()->id)->first();

        $data = array(
            'title' => $request->title2,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        );

        try {
            DB::beginTransaction();

            $image = $request->file('photo2');

            if ($image) {
                $imgName = md5(str_random(30) . time() . '_' . $request->file('photo2')) . '.' . $request->file('photo2')->getClientOriginalExtension();

                $request->file('photo2')->move('uploads/medical_records/', $imgName);

                if (file_exists('uploads/medical_records/' . $dataDOc->image) AND !empty($dataDOc->image)) {
                    unlink('uploads/medical_records/' . $dataDOc->image);
                }
                $data['image'] = $imgName;
            }

            PatientMedicalRecord::FindOrFail($request->row_id)->update($data);

            DB::commit();

            return redirect(url('medical-records'))->withInput()->with('successMsg', 'Data Successfully Updated.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('medical-records'))->withInput()->with('errorMsg', 'Something Went Wrong');
        }
    }

    function DeleteMedicalRecord($id)
    {
        try {
            DB::beginTransaction();

            PatientMedicalRecord::FindOrFail($id)->delete();

            DB::commit();

            return redirect(url('medical-records'))->withInput()->with('successMsg', 'Data Successfully Deleted.');
        } catch (Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('medical-records'))->withInput()->with('errorMsg', 'Something Went wrong');
        }
    }

    function getDataMedicalRecord(Request $request)
    {
        $data = PatientMedicalRecord::FindOrFail($request->row_id);
        return json_encode($data);
    }

    function AddPrescriptionComment(Request $request)
    {
        $doctor_id = PatientPrescriptionDetails::where('booking_id', $request->row_id_comment)->first()->created_by;

        try {
            DB::beginTransaction();

            $rating = $request->rating;
            $data = [

                'comment' => $request->comment,
                'prescription_id' => $request->row_id_comment,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'doctor_id' => $doctor_id,
                'rating' => $rating,

            ];

            $data = PatientPrescriptionComments::insert($data);

            $dt_array = array(
                'rating' => $rating
            );

            // DB::enableQueryLog();

            $result = PatientPrescriptionDetails::where('booking_id', $request->row_id_comment)->update($dt_array);

            //$queries = DB::getQueryLog();

            // print_r($queries);exit();

            DB::commit();

            return redirect(url('appointment-booking'))->withInput()->with('successMsg', 'Data Successfully Sent.');

        } catch (Exception $e) {

            DB::rollback();
            $message = $e->getMessage();
            return redirect(url('appointment-booking'))->withInput()->with('errorMsg', 'Something Went wrong');

        }
    }

    function notifications()
    {
        $user = Auth::user()->id;

        $role_id = Auth::user()->role_id;

        $data['data'] = Notifications::where('created_for', $user)->orderBy('id', 'desc')->get();

        $data['body'] = 'backend/notifications';
        return view('backend/dashboard', $data);
    }

    function readUnreadUpdate(Request $request)
    {
        $row_id = $request->input('id');

        $response = DB::table('notifications')->where('read_unread_status', 0)->where('id', $row_id)->update(['read_unread_status' => 1, 'status' => 1]);

        //dd($response);

        return redirect(url('notifications'));
    }

    public function reportPatient()
    {
        $user_id = Auth::user()->id;

        try {
            $videoList = TwilioVideo::join('twilio_video_logs', 'twilio_videos.id', '=', 'twilio_video_logs.twilio_video_id')
                ->join('users', function ($join) {
                    $join->on('users.id', '=', 'twilio_video_logs.ParticipantIdentity');
                    $join->on('users.id', '!=', DB::raw("''"));
                })
                ->where('twilio_videos.callerUserId', '=', $user_id)
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

        $data['body'] = 'backend/patient/report_patient';
        return view('backend/dashboard', $data);
    }

    public function packageOrderPatient()
    {
        try {
            $data['datas'] = BookedPackage::join('health_packages', function ($join) {
                $join->on('booked_packages.package_id', '=', 'health_packages.id');
                $join->on('booked_packages.package_id', '!=', DB::raw("''"));
            })
                ->where('booked_packages.created_by', Auth::user()->id)
                ->get();
        } catch (Exception $e) {
            $data['datas'] = [];
        }

        $data['body'] = 'backend/patient/patient_package_order';
        return view('backend/dashboard', $data);
    }

    public function serviceOrderPatient()
    {
        try {
            $data['datas'] = BookedService::join('services', function ($join) {
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
        } catch (Exception $e) {
            $data['datas'] = [];
        }

        $data['body'] = 'backend/patient/patient_service_order';
        return view('backend/dashboard', $data);
    }

    function OnlineAppointment()
    {
        $selected_speciality = ['Coronavirus related',
            'General physician',
            'Gynecology ',
            'Dermatology',
            'Psychiatry',
            'Stomach and digestion',
            'Pediatrics',
            'E.N.T',
            'Kidney and urine',
            'Orthopedic',
            'Neurology',
            'Cardiology',
            'Diet and Nutrition',
            'Diabetes and endocrinology',
            'Eye and vision',
            'Dental',
            'Breathing and chest',
            'Cancer',
            'Physiotherapy',
            'General Surgery'];

        $data['specialities'] = Speciality::where('status',1)->orderBy('speciality_name','ASC')->whereIn('speciality_name',$selected_speciality)->get();

        $data['body'] = 'backend/patient/online_appointment';
        return view('backend/dashboard', $data);
    }

    function doc_data_using_speciality(Request $request)
    {
        $speciality_id = $request->speciality_id;

        $doc_datas = DoctorsSpecialityDetails::with('get_doctor')->where('speciality_id', $speciality_id)->groupBy('doctor_id')->get();

        //constraining eager loads laravel need to add for order  by

        if($doc_datas->count() > 0){
        ?>

        <table id="example" class="display table " style="width:100%">
            <thead>
            <tr>
                <td>Sl#</td>
                <th>Doctor Name</th>
                <th>Fees</th>
                <th>Specialities</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
        <?php
            $i = 1;
        foreach ($doc_datas as $doc_data)
        {
            if($doc_data->get_doctor->status == 1){

                $doc_spe_datas = DoctorsSpecialityDetails::with('get_speciality')->where('doctor_id',$doc_data->get_doctor->created_by)->get();
                //constraining eager loads laravel need to add for order  by
                ?>


            <tr>
                <td><?=$i++;?></td>
                <td><?=$doc_data->get_doctor ? $doc_data->get_doctor->doctor_name : '';?></td>
                <td><?=$doc_data->get_doctor ? $doc_data->get_doctor->visiting_fees." tk" : '';?></td>
                <td>
                    <?php
                    foreach ($doc_spe_datas as $doc_spe_data)
                    {
                        echo $doc_spe_data->get_speciality ? $doc_spe_data->get_speciality->speciality_name."<b>,</b> " : '';
                    }
                    ?>

                </td>
                <td>
                    <?php if($doc_data->get_user->online_activity == 1){?>
                    <svg height="100" width="100">
                        <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="green" />
                    </svg>
                    <?php }else{?>
                        <svg height="100" width="100">
                            <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" />
                        </svg>
                    <?php } ?>
                </td>
                <td>
                    <button class="btn btn-warning" <?php if($doc_data->get_user->online_activity == 0){?> disabled <?php } ?> >Call</button></td>

                    <?php /*if($doc_data->get_user->online_activity == 1){*/?><!--
                        <button class="btn btn-warning" >Call</button>
                    <?php /*}else{*/?>

                            <span style="font-weight: bold">Not Available</span>

                    --><?php /*} */?>
            </tr>


        <?php } } ?>
            </tbody>
            <tfoot>
            <tr>
                <td>Sl#</td>
                <th>Doctor Name</th>
                <th>Fees</th>
                <th>Specialities</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>

        <?php
        }
        else
            {
            ?>
            <h3 align="center">No Match Found</h3>
            <?php
        }
    }
}
