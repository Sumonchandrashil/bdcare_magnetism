<?php

namespace App\Http\Controllers\PackageService;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\PackageService\HelpCenter;

use Illuminate\Support\Facades\Auth;
use DB;


class HelpCenterController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            //return HelpCenter::orderBy('id', 'desc')->paginate($request->perPage);
            return datatables()->of(HelpCenter::query())->toJson();
        }
        return view('package_service.help_center');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'              => 'required|unique:help_centers,title',
            'entry_date'         => 'required',
            'terms_condition'    => 'required',
        ]);

        $date = str_replace('/', '-', $request->entry_date);
        $date_val =date('Y-m-d', strtotime($date));
        $data = [
            'title'             => $request->title,
            'entry_date'        => $date_val,
            'terms_condition'   => $request->terms_condition,
            'status'            => $request->status,
            'created_by'        => Auth::user()->id,
        ];

        try {
            DB::beginTransaction();

            HelpCenter::create($data);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Help Center successfully saved!']);
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
        //return HelpCenter::FindOrFail($id);
        $editModeData= HelpCenter::findOrFail($id);
        $data = [
            'id'                => $editModeData->id,
            'title'             =>$editModeData->title,
            'entry_date'        => date('d/m/Y', strtotime($editModeData->entry_date)),
            'terms_condition'   =>$editModeData->terms_condition,
            'status'            =>$editModeData->status,
        ];
        return $data;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'              => 'required|unique:help_centers,title,'.$id.',id',
            'entry_date'         => 'required',
            'terms_condition'    => 'required',
        ]);

        $data = HelpCenter::findOrFail($id);
        $input = $request->all();
        $date = str_replace('/', '-', $request->entry_date);
        $date_val =date('Y-m-d', strtotime($date));
        $input['entry_date'] = $date_val;
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
            return response()->json(['status' => 'success', 'message' => 'Help Center successfully Updated !']);
        } elseif ($bug == 1062) {
            return response()->json(['status' => 'error', 'message' => 'Help Center is Found Duplicate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function destroy($id)
    {
        $data = HelpCenter::FindOrFail($id);
        try{
            $data->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Help Center successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table,can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }
}
