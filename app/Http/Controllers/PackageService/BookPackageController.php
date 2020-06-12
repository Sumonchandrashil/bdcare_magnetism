<?php

namespace App\Http\Controllers\PackageService;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class BookPackageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //return datatables()->of(BookedPackage::query())->toJson();
            $query = DB::table('booked_packages')
                ->leftJoin('health_packages', 'booked_packages.package_id', '=', 'health_packages.id')
                ->whereNull('booked_packages.deleted_at')
                ->select(['booked_packages.id AS id',
                    'booked_packages.name',
                    'booked_packages.email',
                    'booked_packages.number',
                    'booked_packages.address',
                    'booked_packages.package_id',
                    'health_packages.package_name',
                ]);

            return datatables()->of($query)->toJson();
        }
        return view('package_service.book_packages');
    }
}
