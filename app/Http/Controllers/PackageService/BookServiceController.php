<?php

namespace App\Http\Controllers\PackageService;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class BookServiceController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            //return datatables()->of(BookedPackage::query())->toJson();
            $query = DB::table('booked_services')
                ->leftJoin('services', 'booked_services.service_id', '=', 'services.id')
                ->whereNull('booked_services.deleted_at')
                ->select(['booked_services.id AS id',
                    'booked_services.name',
                    'booked_services.email',
                    'booked_services.number',
                    'booked_services.address',
                    'booked_services.service_id',
                    'services.name as service_name',
                ]);
            return datatables()->of($query)->toJson();
        }
        return view('package_service.book_services');
    }
}
