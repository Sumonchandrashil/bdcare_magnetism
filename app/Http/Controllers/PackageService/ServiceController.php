<?php

namespace App\Http\Controllers\PackageService;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\PackageService\Service;

use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Image;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Service::orderBy('id', 'desc')->paginate($request->perPage);
        }
        return view('package_service.services');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required',
            'terms'             => 'required',
            'details'           => 'required',
            'service_date'      => 'required',
            'hot_line_number'   => 'required',
        ]);

        $imageData = $request->get('image');

        if ($imageData) {
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('/uploads/service_photo/') . $fileName);
            $FilePath=  "/uploads/service_photo/".$fileName;
            $data['image'] = $FilePath;

        } 

        if($imageData != ''){
            $data = [
                'name'               => $request->name,
                'terms'              => $request->terms,
                'details'            => $request->details,
                'service_date'       => date('Y-m-d'),
                'hot_line_number'    => $request->hot_line_number,
                'image'              => $FilePath,
                'status'             => $request->status,
                'created_by'         => Auth::user()->id,

            ];

        }else {
            $data = [
                'name'               => $request->name,
                'terms'              => $request->terms,
                'details'            => $request->details,
                'service_date'       => date('Y-m-d'),
                'hot_line_number'    => $request->hot_line_number,
               // 'image'              => $FilePath,
                'status'             => $request->status,
                'created_by'         => Auth::user()->id,

            ];
        }


        try {
            DB::beginTransaction();

             Service::create($data);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Service successfully saved!']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Something Went wrong']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        try {
            $editModeData = Service::FindOrFail($id);

            return response()->json(['status'=>'success','data'=>$editModeData]);
        } catch(\Exception $e){
            $message = $e->getMessage();
            return response()->json(['status'=>'error','data'=>[$message]]);
        }
    }


    public function update(Request $request, $id)
    {
        $editModeData = Service::FindOrFail($id);

        $this->validate($request, [
            'name'              => 'required',
            'terms'             => 'required',
            'details'           => 'required',
            'service_date'      => 'required',
            'hot_line_number'   => 'required',
        ]);

        $imageData = $request->get('simage');

        if ($imageData) {

            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('simage'))->save(public_path('/uploads/service_photo/') . $fileName);
            $FilePath= "/uploads/service_photo/" . $fileName;
            $data['image'] = $FilePath;

            if ($editModeData->image != '' && file_exists(public_path('/uploads/service_photo/') . $editModeData->image)) {
                unlink(public_path('/uploads/service_photo/') . $editModeData->image);
            }
        }


        if($imageData != ''){
            $data = [
                'name'             => $request->name,
                'terms'            => $request->terms,
                'details'          => $request->details,
                'service_date'     => date('Y-m-d'),
                'hot_line_number'  => $request->hot_line_number,
                'image'            => $FilePath,
                'status'           => $request->status,
                'updated_by'       => Auth::user()->id,
            ];

        }else {
            $data = [
                'name' => $request->name,
                'terms' => $request->terms,
                'details' => $request->details,
                'service_date' => date('Y-m-d'),
                'hot_line_number' => $request->hot_line_number,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
            ];
        }

        try {
            DB::beginTransaction();

            $editModeData->update($data);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Service successfully saved!']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Something Went wrong']);
        }
    }

    public function destroy($id)
    {
        try{
            Service::FindOrFail($id)->delete();

            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
            $message = $e->getMessage();
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Patients Data successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table, can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => $message]);
        }
    }
}
