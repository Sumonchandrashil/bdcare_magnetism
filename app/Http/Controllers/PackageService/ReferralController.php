<?php

namespace App\Http\Controllers\PackageService;

use App\Http\Controllers\Controller;
use App\Model\PackageService\Referral;
use DB;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Referral::query()
                ->leftJoin('foreign_hospitals', 'foreign_hospitals.id', '=', 'referral.foreign_hospital_id')
                ->whereNull('referral.deleted_at')
                ->orderBy('id', 'desc')
                ->select([
                    'referral.id',
                    'referral.patient_name',
                    'referral.patient_age',
                    'referral.care_giver_name',
                    'referral.care_giver_age',
                    'referral.passport_no',
                    'referral.wheel_chair',
                    'referral.address',
                    'referral.mobile_number',
                    'referral.email',
                    'referral.date_of_travel',
                    'referral.foreign_hospital_id',
                    'referral.medical_report',
                    'foreign_hospitals.hospital_name',
                ]);
            return datatables()->of($query)->toJson();
        }

        return view('package_service.referral_hospital');
    }
}
