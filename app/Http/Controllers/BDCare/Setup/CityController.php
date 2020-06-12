<?php

namespace App\Http\Controllers\BDCare\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BDCare\Setup\City;
use Illuminate\Support\Facades\Auth;
use DB;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return datatables()->of(City::query())->toJson();
        }


    }

    public function create()
    {
         return view('bdcare.setup.city');
    }

    public function store(Request $request)
    {   //dd($request);
        $this->validate($request, [
            'city_name'=>'required|unique:cities,city_name',
            'status'=>'required',
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();
            City::create($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'City successfully saved !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'City is Found Duplicate']);
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
        return City::FindOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'city_name'=>'required',
            'status'=>'required',
        ]);

        $data = City::findOrFail($id);
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
            return response()->json(['status' => 'success', 'message' => 'Product Category successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'Product Category is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        $data = City::FindOrFail($id);
        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'City successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
