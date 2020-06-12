<?php

namespace App\Http\Controllers\BDCare\Setup;

use App\Lib\ImageFilePath;
use App\Model\BDCare\Setup\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BDCare\Setup\HealthPackage;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;

class HealthPackageController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()){
            $query = DB::table('health_packages')
                ->leftJoin('cities', 'health_packages.location', '=', 'cities.id')
                ->whereNull('health_packages.deleted_at')
                ->select(['health_packages.id AS id',
                    'health_packages.package_name',
                    'health_packages.age_group',
                    'health_packages.no_of_tests',
                    'health_packages.description',
                    'health_packages.price',
                    'health_packages.discount',
                    'health_packages.location',
                    'health_packages.status',
                    'cities.city_name',
                ]);

            return datatables()->of($query)->toJson();

        }

    }

    public function create()
    {
         $location = City::get();
         return view('bdcare.setup.health_package',compact('location'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'package_name'=>'required|unique:health_packages,package_name',
            'status'=>'required',
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;

        $imageData = $request->get('photo');
        if ($imageData) {
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('photo'))->save(public_path(ImageFilePath::$healthPackagePhoto) . $fileName);
            $input['photo'] = $fileName;
        }

        try {
            DB::beginTransaction();
            HealthPackage::create($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Health Package successfully saved !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'Health Package is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return HealthPackage::FindOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'package_name'=>'required',
            'status'=>'required',
        ]);

        $data = HealthPackage::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

        $imageData = $request->get('package_photo');
        if ($imageData) {
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('package_photo'))->save(public_path(ImageFilePath::$healthPackagePhoto) . $fileName);
            $input['photo'] = $fileName;

            if ($data->photo != '' && file_exists(ImageFilePath::$healthPackagePhoto . $data->photo)) {
                unlink(ImageFilePath::$healthPackagePhoto . $data->photo);
            }
        }

        try {
            DB::beginTransaction();
            $data->update($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Healty Package successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'Package is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        $data = HealthPackage::FindOrFail($id);

        if ($data->photo != '' && file_exists(ImageFilePath::$healthPackagePhoto . $data->photo)) {
            unlink(ImageFilePath::$healthPackagePhoto . $data->photo);
        }

        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Health Package successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
