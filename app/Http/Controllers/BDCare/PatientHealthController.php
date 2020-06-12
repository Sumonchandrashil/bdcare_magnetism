<?php

namespace App\Http\Controllers\BDCare;

use App\Http\Controllers\Controller;
use App\Model\BDCare\PatientMedicalRecord;
use Auth;
use DB;
use Illuminate\Http\Request;

class PatientHealthController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return PatientMedicalRecord::query()->paginate($request->perPage);
        }
        $patientHealth = PatientMedicalRecord::query()->get();
        return view('bdcare.patient_health', compact('patientHealth'));
    }
}
