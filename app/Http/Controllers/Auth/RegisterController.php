<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\APIRegisterController;
use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\PatientData;
use App\User;
use Auth;
use DB;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function signup(Request $request)
    {

        //dd($request);
        if ($_POST['type'] == 0) {
            Session::flush();
            return redirect(url('register'))->withInput()->with('errorMsg', 'User type not selected');
        }

        //if ($_POST['name'] == '' or $_POST['email'] == '' or $_POST['mobile'] == '') {
        if ($_POST['name'] == '' or $_POST['mobile'] == '') {
            Session::flush();
            return redirect(url('register'))->withInput()->with('errorMsg', 'All fields are required');
        }

        $data['user_name'] = $_POST['name'];
        //$data['email'] = $_POST['email'];
        $data['mobile'] = $_POST['mobile'];
        $data['password'] = $_POST['password'];
        $conf_password = $_POST['conf_password'];
        $data['status'] = 0;
        $data['role_id'] = $_POST['type'];

        //$checked_user = User::where('email', $_POST['email'])->where('mobile', $_POST['mobile'])->where('status', 0)->get();
        $checked_user = User::where('mobile', $_POST['mobile'])->where('status', 0)->get();

        if ($checked_user->count() > 0) {
            
            $this->validate($request, [
                'name' => 'required|string|max:255',
                //'email' => 'required|string|email|max:255',
                'mobile' => 'required|numeric|digits:11',
                'password' => 'min:6|required_with:conf_password|same:conf_password',
                'conf_password' => 'min:6'
            ], [
                'name.required' => 'name field can not be empty.',
                'name.max' => 'name field lenght should be less than 255.',
                //'email.required' => 'Email field can not be empty.',
                'mobile.min' => 'mobile must be 11 digit.',
                'mobile.max' => 'mobile must be 11 digit.',
                'password.required' => 'Password field Required should mathed with Cofirm password.',
            ]);

            if ($data['password'] != $conf_password) {
                Session::flush();
                return redirect(url('register'))->withInput()->with('errorMsg', 'Password not matched! Try Again');
            } else {
                $data['password'] = Hash::make($data['password']);
                try {
                    $mob = $_POST['mobile'];
                    $data['user_id'] = $checked_user->first()->id;
                    $user_id = $data['user_id'];
                    $code = mt_rand(100000, 999999);//six digit//$currentId.date('my');

                    Session::put('secret_code', $code);
                    Session::put('user_id', $user_id);
                    session::put('loggin_password', $conf_password);

                    APIRegisterController::TwoStepVarificaion($mob, $code);

                    $secret_code['code'] = $code;

                    User::where('id', $user_id)->update($secret_code);

                    $name = $request->input('name');
                    //$email = $request->input('email');
                    $mobile = $request->input('mobile');

                    DB::commit();

                    return redirect(url('otp'))->withInput()->with('code', $code);

                    //return redirect(url('admin-login'))->withInput()->with('successMsg','Successfully Signed Up Please Login.');

                } catch (Exception $e) {
                    DB::rollback();
                    //$message = $e->getMessage();
                    return redirect(url('register'))->withInput()->with('errorMsg', 'Something went wrong');
                }
            }
        } else {
            //echo $_POST['mobile'];exit();
            $this->validate($request, [
                'name' => 'required|string|max:255',
                //'email' => 'required|string|email|max:255|unique:users',
                'mobile' => 'required|numeric|digits:11|unique:users',
                'password' => 'min:6|required_with:conf_password|same:conf_password',
                'conf_password' => 'min:6'
            ], [
                'name.required' => 'name field can not be empty.',
                'name.max' => 'name field lenght should be less than 255.',
                //'email.required' => 'Email field can not be empty.',
                //'email.unique' => 'Email must be unique.Given one already used',
                'mobile.unique' => 'mobile must be unique.Given one already used',
                'mobile.min' => 'mobile must be 11 digit.',
                'mobile.max' => 'mobile must be 11 digit.',
                'password.required' => 'Password field Required should mathed with Cofirm password.',
            ]);

            if ($data['password'] != $conf_password) {
                Session::flush();
                return redirect(url('register'))->withInput()->with('errorMsg', 'Password not matched! Try Again');
            } else {
                $data['password'] = Hash::make($data['password']);
                try {

                    DB::beginTransaction();

                    DB::enableQueryLog();

                    $result = User::create($data);

                    //dd(DB::getQueryLog()); // Show results of log

                    $mob = $_POST['mobile'];

                    $id = User::max('id');

                    $currentId = $id;

                    $code = mt_rand(100000, 999999);//R60005625cb5ac9cbcdfc0.73859382 $currentId.date('my');

                    Session::put('secret_code', $code);
                    Session::put('user_id', $id);
                    session::put('loggin_password', $conf_password);

                    APIRegisterController::TwoStepVarificaion($mob, $code);

                    $secret_code['code'] = $code;

                    User::where('id', $id)->update($secret_code);

                    if ($data['role_id'] == 3) {
                        $data_doctor['doctor_name'] = $_POST['name'];
                        //$data_doctor['email'] = $_POST['email'];
                        $data_doctor['emergency_contact'] = $_POST['mobile'];
                        $data_doctor['created_by'] = $currentId;

                        $result2 = DoctorsData::insert($data_doctor);

                        $doctor_detail_data['doctor_id'] = DoctorsData::max('id');

                        /*$resultDegree = DoctorsDegreeDetails::insert($doctor_detail_data);
                        $resultSpeciality = DoctorsSpecialityDetails::insert($doctor_detail_data);
                        $resultHospital = DoctorsHospitalDetails::insert($doctor_detail_data);*/
                    } elseif ($data['role_id'] == 4) {
                        $data_patient['patient_name'] = $_POST['name'];
                        //$data_patient['email'] = $_POST['email'];
                        $data_patient['contact'] = $_POST['mobile'];
                        $data_patient['created_by'] = $currentId;

                        $result3 = PatientData::insert($data_patient);

                        $data_details['patient_id'] = PatientData::max('id');

                        /*$result4 = PatientDiseaseDetails::insert($data_details);
                        $result5 = PatientSurgeryDetails::insert($data_details);
                        $result6 = PatientAllergyDetails::insert($data_details);*/

                    }

                    $name = $request->input('name');
                    //$email = $request->input('email');
                    $mobile = $request->input('mobile');

                    DB::commit();

                    return redirect(url('otp'))->withInput()->with('code', $code);

                    //return redirect(url('admin-login'))->withInput()->with('successMsg','Successfully Signed Up Please Login.');

                } catch (Exception $e) {
                    DB::rollback();
                    //$message = $e->getMessage();
                    return redirect(url('register'))->withInput()->with('errorMsg', 'Something went wrong');
                }

            }
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected
    function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected
    function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
