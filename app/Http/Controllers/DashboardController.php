<?php

namespace App\Http\Controllers;
use App\Model\BDCare\DoctorsData;
use App\Model\BDCare\PatientAppointmentDetails;
use App\Model\BDCare\PatientData;
use App\Model\BDCare\Setup\Hospital;
use App\Model\PackageService\Service;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(){

        if(Auth::user()->role_id == 1) {
            $services = Service::get()->count();
            $hospitals = Hospital::get()->count();
            $appointments = PatientAppointmentDetails::get()->count();
            $doctors = User::where('role_id', 3)->get()->count();
            $patients = User::where('role_id', 4)->get()->count();
            $users = User::get()->count();
            return view('dashboard', compact('services', 'doctors', 'hospitals', 'appointments', 'patients', 'users'));
        }
        else
        {
            $data['body'] = 'backend.body';
            return view('backend/dashboard',$data);
        }

    }
}
