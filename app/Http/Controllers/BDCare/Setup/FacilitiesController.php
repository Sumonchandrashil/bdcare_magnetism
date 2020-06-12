<?php

namespace App\Http\Controllers\BDCare\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BDCare\Setup\facility;
use Illuminate\Support\Facades\Auth;
use DB;

class FacilitiesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return datatables()->of(facility::query())->toJson();
        }

        //return facility::orderBy('facility_name','asc')->paginate($request->perPage);

    }

    public function create()
    {
         return view('bdcare.setup.facility');
    }

    public function store(Request $request)
    {   //dd($request);
        $this->validate($request, [
            'facility_name'=>'required|unique:facilities,facility_name',
            'status'=>'required',
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();
            facility::create($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'facility successfully saved !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'facility is Found Duplicate']);
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
        return facility::FindOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'facility_name'=>'required',
            'status'=>'required',
        ]);

        $data = facility::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = Auth::user()->id;

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
            return response()->json(['status' => 'success', 'message' => 'Facility successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'Facility is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        $data = facility::FindOrFail($id);
        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Facility successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
