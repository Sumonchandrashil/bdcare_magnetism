<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Session;
use Validator;


class LoginController extends Controller
{
    public static function otp()
    {
        return view('otp');
    }

    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended(url('dashboard'));
        }
        return view('login');
    }

    function showLoginForm()
    {
        return view('register');
    }

    function register()
    {
        return view('register');
    }

    public function Auth(LoginRequest $request)
    {
        if (Auth::attempt(['mobile' => $request->email, 'password' => $request->password])) {
            $userStatus = Auth::User()->status;

            if ($userStatus == '1') {
                $user_data = [
                    "id" => Auth::user()->id,
                    "email" => Auth::user()->email,
                    "user_name" => Auth::user()->user_name,
                    "role_id" => Auth::user()->role_id,
                    "user_photo" => Auth::user()->user_photo
                ];

                $activity['online_activity'] = 1;

                User::where('id',Auth::user()->id)->update($activity);

                session()->put('logged_session_data', $user_data);
                //return redirect()->intended(url('/dashboard'));
                //echo Session::get('prev_url');exit();
                if (Session::get('prev_url')) {
                    return redirect(Session::get('prev_url'));
                } else {
                    if (Auth::user()->role_id == 1) {
                        return redirect(url('dashboard'))->with('successMsg', 'Successfully Logged In');
                    }
                    return redirect(url('UserProfile'))->with('successMsg', 'Successfully Logged In');
                }
            } else {
                Auth::logout();
                Session::flush();
                return redirect(url('admin-login'))->withInput()->with('errorMsg', 'You are temporary blocked. please contact to admin');
            }
        } else {
            return redirect(url('admin-login'))->withInput()->with('errorMsg', 'Incorrect username or password. Please try again.');
        }
    }

    public function logout()
    {
        $user = session()->get('logged_session_data')['id'];
        $activity['online_activity'] = 0;

        User::where('id',$user)->update($activity);

        Auth::logout();
        Session::flush();
        return redirect('admin-login')->with('successMsg', 'Successfully Logged Out');
    }

    function validatingsignup(Request $request)
    {
        $value = Session::get('secret_code');
        $user_id = Session::get('user_id');

        $data['status'] = 1;

        $secret_code = $request->secret_code;

        if ($value == $secret_code)
        {
            User::where('id', $user_id)->update($data);

            $user_date = User::where('id', $user_id)->first();

            $usename = $user_date->mobile;
            $password = Session::get('loggin_password');

            if (Auth::attempt(['mobile' => $usename, 'password' => $password]))
            {
                $userStatus = Auth::User()->status;

                if ($userStatus == '1')
                {
                    $user_data = [
                        "id" => Auth::user()->id,
                        "email" => Auth::user()->email,
                        "user_name" => Auth::user()->user_name,
                        "role_id" => Auth::user()->role_id,
                        "user_photo" => Auth::user()->user_photo
                    ];

                    session()->put('logged_session_data', $user_data);
                    //return redirect()->intended(url('/dashboard'));
                    //echo Session::get('prev_url');exit();
                    if (Session::get('prev_url'))
                    {
                        return redirect(Session::get('prev_url'));
                    }
                    else
                    {
                        if (Auth::user()->role_id == 1) {
                            return redirect(url('dashboard'))->with('successMsg', 'Successfully Logged In');
                        }
                        return redirect(url('UserProfile'))->with('successMsg', 'Successfully Logged In');
                    }
                } else {
                    Auth::logout();
                    Session::flush();
                    return redirect(url('admin-login'))->withInput()->with('errorMsg', 'You are temporary blocked. please contact to admin');
                }
            } else {
                return redirect(url('admin-login'))->withInput()->with('errorMsg', 'Incorrect username or password. Please try again.');
            }

            return redirect(url('admin-login'))->withInput()->with('successMsg', 'Successfully Signed Up and verified your mobile no Please Login.');
        } else {
            return redirect(url('otp'))->withInput()->with('code', $value);
        }
    }
}

