<?php

namespace App\Http\Controllers\Api;

use App\Model\PackageService\HelpCenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\DoctorsData;

class APIRegisterController extends Controller
{
    public function register(Request $request)
    {
        $mobile = $request->mobile;
        $email = $request->email;

        $checked_user = User::where('email',$email)->where('mobile',$mobile)->where('status',0)->get();

        if($checked_user->count() > 0)
        {
            $data['status'] = true;
            $data['message'] = 'success';
            $data['user_id'] = $checked_user->first()->id;

            $code = mt_rand(100000, 999999);//six digit//$currentId.date('my');

            $this->TwoStepVarificaion($mobile,$code);

            $secret_code['code'] = $code;

            User::where('id',$data['user_id'])->update($secret_code);

            $data['status'] = true;
            $data['user_id'] = $data['user_id'];
            $data['message'] = 'Success';

            DB::commit();

            return response()->json($data);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|numeric|digits:11|unique:users',
            'user_name' => 'required',
            'role_id' => 'required',
            'password'=> 'required'
        ]);

        if ($validator->fails()) {

            $data['status'] = false;
            $data['message'] = 'Validation Failed';

            return response()->json($data);
        }

        try{

            DB::beginTransaction();

            User::create([
                'user_name'     => $request->get('user_name'),
                'email'         => $request->get('email'),
                'mobile'        => $request->get('mobile'),
                'role_id'       => $request->get('role_id'),
                'status'        => 0,
                'password'      => bcrypt($request->get('password')),
            ]);

            $user = User::first();

            $token = JWTAuth::fromUser($user);

            $id = User::max('id');

            $currentId = $id;

            if($request->get('role_id') == 4)
            {
                $data_patient['patient_name'] = $request->get('user_name');
                $data_patient['email'] = $request->get('email');
                $data_patient['contact'] = $request->get('mobile');
                $data_patient['created_by']= $currentId;

                PatientData::insert($data_patient);
            }
            elseif ($request->get('role_id') == 3)
            {
                $id = User::max('id');
                $currentId = $id;

                $data_doctor['doctor_name'] = $request->get('user_name');
                $data_doctor['email'] = $request->get('email');
                $data_doctor['emergency_contact'] = $request->get('mobile');
                $data_doctor['created_by']= $currentId;

                DoctorsData::insert($data_doctor);

                $doctor_detail_data['doctor_id'] = DoctorsData::max('id');
            }

            $code = mt_rand(100000, 999999);//$currentId.date('my');

            $this->TwoStepVarificaion($request->get('mobile'),$code);

            $secret_code['code'] = $code;

            User::where('id',$id)->update($secret_code);

            $data['status'] = true;
            $data['user_id'] = $currentId;
            $data['message'] = 'Success';

            DB::commit();

        }
        catch (\Exception $e)
        {
            DB::rollback();
            $message = $e->getMessage();
            $data['status'] = false;
            $data['message'] = 'Failed';
        }

        return response()->json($data);

    }

    public static function TwoStepVarificaionMobile(Request $request)
    {
        $data['status'] = 1;

        $user = $request->user_id;
        $code = $request->code;

        $user_detail = User::where('id',$user)->get();

        if($user_detail->count() > 0)
        {
            $secret_code = $user_detail->first()->code;
            $role_id = $user_detail->first()->role_id;

            if($secret_code == $code)
            {

                User::where('id',$user)->update($data);

                $data['status'] = True;
                $data['role_id'] = $role_id;
                $data['message'] = 'Success Code Matched';
            }
            else{
                $data['status'] = false;
                $data['message'] = 'Failed Code not matched';
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'User not found';
        }

        return response()->json($data);
    }

    public static function TwoStepVarificaion($mob,$code)
    {
        // $msg = "Thank you selecting BDCare your secret code is: $code";
        $msg = "BDCare: $code";
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "http://sms.bulksmsroute.com/smsapi?api_key=R60005625cb5ac9cbcdfc0.73859382&type=text&contacts=$mob&senderid=BDCARE&msg=$msg");

        $getStatusCode = $response->getStatusCode(); # 200

        # Send an asynchronous request.
        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
        $promise = $client->sendAsync($request)->then(function ($response) {
            //echo 'I completed! ' . $response->getBody();
            return 'TRUE';
        });

        $promise->wait();
    }


    function askDoctor(Request $request){
        /*$symp = '';

        for ($i=0;$i<count($request->Symptom); $i++)
        {
            $symp .= $request->Symptom[$i].',';

        }
        $symp_all = rtrim($symp,',');*/


        $dataAskDoctor = [
            'title'    => $request->title,
            'email'    => $request->email,
            'terms_condition'    => $request->Symptom,
            'entry_date'    => date('Y-m-d'),
            'status'        => 2,
        ];


        try{
            DB::beginTransaction();
            $exists = HelpCenter::create($dataAskDoctor);

            $data['status'] = true;
            $data['message'] = 'Success';
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed';
        }
        return response()->json($data);
    }


}
