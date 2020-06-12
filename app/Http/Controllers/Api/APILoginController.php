<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\BDCare\DoctorsData;
use App\User;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use JWTFactory;
use Mail;
use Session;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;


class APILoginController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            $data['status'] = false;
            $data['message'] = $validator->errors()->first();
            return response()->json($data);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                $data['status'] = false;
                $data['message'] = 'Invalid credentials';
                return response()->json($data);
            }

            $user = User::select('id', 'user_name', 'email', 'status', 'role_id', 'user_photo')
                ->where('email', $request->get('email'))
                ->where('status', 1)
                ->first();

            $data['status'] = true;
            $data['message'] = 'Success';
            $data['data'] = $user;
            $data['token'] = $token;

        } catch (JWTException $e) {
            $data['status'] = false;
            $data['message'] = 'Could not create token';
            return response()->json($data);
        }

        return response()->json($data);
    }

    function check_token(Request $request)
    {
        /*try {


            $user = JWTAuth::parseToken()->authenticate();

            $message['status'] = true;
            $message['message'] = 'Valid';

        } catch (Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                $message['status'] = false;
                $message['message'] = 'Token is Invalid';

                //return response()->json(['code'=>404,'message' => 'Token is Invalid'],404);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                $message['status'] = false;
                $message['message'] = 'Token is Expired';

                //return response()->json(['code'=>404,'message' => 'Token is Expired'],404);

            }else{

                $message['status'] = false;
                $message['message'] = 'Authorization Token not found';

                return response()->json(['code'=>404,'status' => 'Authorization Token not found']);

            }
        }*/

        $New_token = $request->token;
        $Old_token = JWTAuth::getToken();

        if ($New_token == $Old_token) {
            $message['status'] = true;
            $message['message'] = 'Valid';
        } else {
            $message['status'] = false;
            $message['message'] = 'Invalid';
        }

        return response()->json($message);

        /*$token = JWTAuth::getToken();
        return response()->json(compact('token'));*/

        /*$oldToken = $request->token;

        $user = User::where('id',$request->id)->first();

        $token = JWTAuth::fromUser($user);

        if($token == $oldToken)
        {
            $token = "valid";
        }else{
            $token = "InValid";
        }
        return response()->json(compact('token'));*/
    }

    function PassReset(Request $request)
    {
        $old_password = $request->get('old_password');
        $password = bcrypt($request->get('password'));
        $user = $request->get('sess_user_id');

        $data = array(
            'password' => $password,
        );

        $email = User::where('id', $user)->get()->first()->email;

        if (Auth::attempt(['email' => $email, 'password' => $old_password])) {
            $userStatus = 1;
        }

        try {
            if (isset($request->sess_user_id) && $userStatus == 1) {
                DB::beginTransaction();

                User::where('id', $user)->update($data);

                $message['status'] = true;
                $message['message'] = 'Password Changed Successfully';

                $credentials = $request->only('email', 'password');
                $message['token'] = JWTAuth::attempt($credentials);

                DB::commit();

            } else {
                $message['status'] = false;
                $message['message'] = 'Password/User Not Matched';
            }
            return response()->json($message);
        } catch (Exception $e) {
            DB::rollback();

            $message['status'] = false;
            $message['message'] = 'Failed';

            return response()->json($message);
        }

    }

    function forget_pass(Request $request)
    {
        $email = $request->email;
        $mobile = $request->mobile;

        $data_status = User::where('mobile', $mobile)->where('email', $email)->get();

        $pass = rand(100000, 500000);

        if ($data_status->count() > 0) {
            $headers = "From: info@bd.care" . "\r\n";

            $msg = "Your new password is : $pass";

            $sub = 'Password Recovery';

            $password['password'] = Hash::make($pass);

            User::where('mobile', $mobile)->where('email', $email)->update($password);

            mail($email, $sub, $msg, $headers);

            $message['status'] = true;
            $message['message'] = 'Success. Please check your email & login again';
        } else {

            $message['status'] = false;
            $message['message'] = 'Failed. Inserted Data not mathced';
        }

        return response()->json($message);
    }

    function token_update(Request $request)
    {
        $user = $request->user_id;

        try {
            $data = array(
                'token' => $request->token
            );

            DB::beginTransaction();

            User::where('id', $user)->update($data);

            $message['status'] = true;
            $message['message'] = 'Token Changed Successfully';

            DB::commit();

            return response()->json($message);
        } catch (Exception $e) {
            DB::rollback();

            $message['status'] = false;
            $message['message'] = 'Failed';

            return response()->json($message);
        }
    }

    function logout(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $token = $request->token;

            $user_type = User::where('id', $user_id)->first();

            if ($user_type) {
                $user_type = $user_type->role_id;

                if ($user_type == 3) {
                    $dt['online'] = 0;
                    DoctorsData::where('created_by', $user_id)->update($dt);
                }
            }

            $data = array(
                'token' => NULL
            );

            User::where('id', $user_id)->update($data);

            JWTAuth::invalidate($token);

            $message['status'] = true;
            $message['message'] = 'Logout Successfull';

            DB::commit();

            return response()->json($message);
        } catch (Exception $e) {
            DB::rollback();

            $message['status'] = false;
            $message['message'] = 'Failed';

            return response()->json($message);
        }
    }
}
