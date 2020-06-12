<?php

namespace App\Http\Controllers\BDCare\Setup;

use App\Model\BDCare\Setup\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BDCare\Setup\Area;
use Illuminate\Support\Facades\Auth;
use DB;

class AreaController extends Controller
{
    public function index(Request $request)
    {

        $query = DB::table('areas')
            ->join('cities', 'areas.city', '=', 'cities.id')
            ->whereNull('areas.deleted_at')
            ->select(['areas.id AS id',
                'areas.area_name',
                'areas.description',
                'areas.status',
                'cities.city_name',
            ]);

        return datatables()->of($query)->toJson();

    }

    public function create()
    {
         $city = City::get();
         return view('bdcare.setup.area',compact('city'));
    }

    public function store(Request $request)
    {   //dd($request);
        $this->validate($request, [
            'city'=>'required',
            'area_name'=>'required|unique:areas,area_name',
            'status'=>'required',
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->id;

        try {
            DB::beginTransaction();
            Area::create($input);
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Area successfully saved !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'Area is Found Duplicate']);
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
        return Area::FindOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'city'=>'required',
            'area_name'=>'required',
            'status'=>'required',
        ]);

        $data = Area::findOrFail($id);
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
            return response()->json(['status' => 'success', 'message' => 'Area successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'Area is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        $data = Area::FindOrFail($id);
        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Area successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
