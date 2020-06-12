<?php

namespace App\Http\Controllers\BDCare\Setup;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\BDCare\Setup\Hospital;
use App\Model\BDCare\Setup\HospitalFacilityDetail;
use App\Model\BDCare\Setup\facility;
use App\Model\BDCare\Setup\Area;
use App\Model\BDCare\Setup\City;
use App\Model\BDCare\Setup\HospitalGalleryImage;
use DB;
use Carbon\Carbon;
use Image;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Hospital::with('get_areas')->with('get_cities')->orderBy('id','desc')->paginate($request->perPage);
        }

        $productLists   = facility::orderBy('facility_name','asc')->get();
        $AreaLists   = Area::orderBy('area_name','asc')->get();
        $CityLists   = City::orderBy('city_name','asc')->get();

        return view('bdcare.setup.hospital',compact('productLists','AreaLists','CityLists'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'hospital_name' => 'required',
            'area_name' => 'required',
            'city_name' => 'required',
            'details.*.facility_id' => 'required',
        ], [
            'details.*.facility_id.required' => 'Required field.',
        ]);

        $imageData = $request->get('cover_image');
        if ($imageData) {
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            $img = Image::make($request->get('cover_image'))->save(public_path('/uploads/hospital_cover_photo/') . $fileName);
            $FilePath=  $fileName;

            $img->resize(320, 240)->save(public_path('/uploads/hospital_cover_photo/thumb/') . $fileName);
        }

        $imageData2 = $request->get('logo');
        if ($imageData2) {
            $fileName2 = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData2, 0, strpos($imageData2, ';')))[1])[1];
            $img = Image::make($request->get('logo'))->save(public_path('/uploads/hospital_logo/') . $fileName2);
            $FilePath2=  $fileName2;

            $img->resize(320, 240)->save(public_path('/uploads/hospital_logo/thumb/') . $fileName2);
        }

        $gallery_files = $request->get('gallery_files');
        $gallery_files_data = [];
        foreach ($gallery_files as $img_file) {
            
            $img_name = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($img_file, 0, strpos($img_file, ';')))[1])[1];
            $img = Image::make($img_file)->save(public_path('/uploads/hospital_gallery/') . $img_name);

            $img->resize(320, 240)->save(public_path('/uploads/hospital_gallery/thumb/') . $img_name); 
           
            $gallery_files_data[] = $img_name;           
        }

        $data = [
            'cover_image' => isset($FilePath) ? $FilePath : '',
            'logo' => isset($FilePath2) ? $FilePath2 : '',
            'hospital_name' => $request->hospital_name,
            'area' => $request->area_name,
            'city' => $request->city_name,
            'description' => $request->description,
            'motto' => $request->motto,
            'address' => $request->address,
            'help_line' => $request->help_line,
            'type' => $request->type,
            'excellence_center' => $request->excellence_center,
            'emergency_details' => $request->emergency_details,
            'web_address' => addhttp($request->web_address),
            'created_by' => Auth::user()->id,
        ];

        try {
            DB::beginTransaction();

            $result = Hospital::create($data);
            $details = $this->dataFormat($request, $result->id);
            HospitalFacilityDetail::insert($details);

            $gallery_details = $this->dataFormatGalleryFiles($gallery_files_data, $result->id);
            HospitalGalleryImage::insert($gallery_details);

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Hospital Data successfully saved!']);
        } catch (\Exception $e) {

            DB::rollback();
            print_r($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong!!!']);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        try {
            $editModeData = Hospital::FindOrFail($id);

            $editModeDetailsData = HospitalFacilityDetail::with('get_hospital')->where('hospital_id',$id)->get();
            $gallery_files = HospitalGalleryImage::where('hospital_id',$id)->get();

            $data = [
                'id'    => $editModeData->id,
                'old_cover_image' => $editModeData->cover_image,
                'cover_image' => NULL,
                'old_logo' => $editModeData->logo,
                'logo' => NULL,
                'hospital_name' => $editModeData->hospital_name,
                'area_name' => $editModeData->area,
                'city_name' => $editModeData->city,
                'address' => $editModeData->address,
                'description' => $editModeData->description,
                'motto' => $editModeData->motto,
                'help_line' => $editModeData->help_line,
                'type' => $editModeData->type,
                'excellence_center' => $editModeData->excellence_center,
                'emergency_details' => $editModeData->emergency_details,
                'web_address' => addhttp($editModeData->web_address),
                'deleteID' => [],
                'details'    => $editModeDetailsData,
                'gallery_files' => [],
                'old_gallery_files' => $gallery_files,
                'gallery_files_deleteID' => [],
            ];
            return response()->json(['status'=>'success','data'=>$data]);
        } catch(\Exception $e){
            return response()->json(['status'=>'error','data'=>[]]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'hospital_name' => 'required',
            'area_name' => 'required',
            'city_name' => 'required',
            'details.*.facility_id' => 'required',
        ], [

            'details.*.facility_id.required' => 'Required field.',
        ]);

        try {
            DB::beginTransaction();

            $hospital = Hospital::FindOrFail($id);

            $cover_image = $hospital->cover_image;
            if ($request->filled('cover_image')) {

                //Delete old cover image
                $delete_img = 'uploads/hospital_cover_photo/'.$cover_image;

                if(file_exists(public_path($delete_img)) && $cover_image != NULL)
                {
                    unlink(public_path($delete_img));
                }

                $delete_thumb = 'uploads/hospital_cover_photo/thumb/'.$cover_image;

                if(file_exists(public_path($delete_thumb)) && $cover_image != NULL)
                {
                    unlink(public_path($delete_thumb));
                }

                //Upload new cover image                
                $newCoverImg = $request->get('cover_image');

                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($newCoverImg, 0, strpos($newCoverImg, ';')))[1])[1];
                $img = Image::make($newCoverImg)->save(public_path('/uploads/hospital_cover_photo/') . $fileName);

                $img->resize(320, 240)->save(public_path('/uploads/hospital_cover_photo/thumb/') . $fileName);
                $cover_image =  $fileName;
            }

            $logo = $hospital->logo;
            if ($request->filled('logo')) {

                //Delete old logo
                $delete_img = 'uploads/hospital_logo/'.$logo;

                if(file_exists(public_path($delete_img)) && $logo != NULL)
                {
                    unlink(public_path($delete_img));
                }

                $delete_thumb = 'uploads/hospital_logo/thumb/'.$logo;

                if(file_exists(public_path($delete_thumb)) && $logo != NULL)
                {
                    unlink(public_path($delete_thumb));
                }

                //Upload new logo              
                $newLogo = $request->get('logo');

                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($newLogo, 0, strpos($newLogo, ';')))[1])[1];
                $img = Image::make($newLogo)->save(public_path('/uploads/hospital_logo/') . $fileName);

                $img->resize(320, 240)->save(public_path('/uploads/hospital_logo/thumb/') . $fileName);
                $logo =  $fileName;
            }

            $data = [
                'cover_image' => $cover_image,
                'logo' => $logo,
                'hospital_name' => $request->hospital_name,
                'area' => $request->area_name,
                'city' => $request->city_name,
                'description' => $request->description,
                'motto' => $request->motto,
                'address' => $request->address,
                'help_line' => $request->help_line,
                'type' => $request->type,
                'excellence_center' => $request->excellence_center,
                'emergency_details' => $request->emergency_details,
                'web_address' => addhttp($request->web_address),
                'updated_by' => Auth::user()->id,
            ];
            $hospital->update($data);

            // Upload New Gallery Images
            $gallery_files_data = [];
            $gallery_files = $request->get('gallery_files');
            foreach ($gallery_files as $img_file) {
                
                $img_name = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($img_file, 0, strpos($img_file, ';')))[1])[1];
                $img = Image::make($img_file)->save(public_path('/uploads/hospital_gallery/') . $img_name);

                $img->resize(320, 240)->save(public_path('/uploads/hospital_gallery/thumb/') . $img_name); 
               
                $gallery_files_data[] = $img_name;           
            }
            $gallery_details = $this->dataFormatGalleryFiles($gallery_files_data, $id);
            HospitalGalleryImage::insert($gallery_details);

            //Delete Gallery Images
            if (count($request->gallery_files_deleteID) > 0) {

                $rows = HospitalGalleryImage::whereIn('id', $request->gallery_files_deleteID)->get();
                foreach ($rows as $row) {

                    $delete_img = 'uploads/hospital_gallery/'.$row->picture;

                    if(file_exists(public_path($delete_img)) && $row->picture != NULL)
                    {
                        unlink(public_path($delete_img));
                    }

                    $delete_thumb = 'uploads/hospital_gallery/thumb/'.$row->picture;

                    if(file_exists(public_path($delete_thumb)) && $row->picture != NULL)
                    {
                        unlink(public_path($delete_thumb));
                    }

                    $row->delete();
                }
            }

            /* Insert update and delete ~~details  */
            if (count($request->deleteID) > 0) {
                HospitalFacilityDetail::whereIn('id', $request->deleteID)->delete();
            }

            $dataFormat = [];
            $count = count($request->details);
            for ($i = 0; $i < $count; $i++) {
                if (isset($request->details[$i]['id']) && $request->details[$i]['id'] !='') {
                    $updateData = [
                        'hospital_id'     => $id,
                        'facility_id'     => $request->details[$i]['facility_id'],
                        'remarks'         => $request->details[$i]['remarks'],
                    ];
                    HospitalFacilityDetail::where('id', $request->details[$i]['id'])->update($updateData);
                } else {
                    $dataFormat[$i] =[
                        'hospital_id'     => $id,
                        'facility_id'     => $request->details[$i]['facility_id'],
                        'remarks'         => $request->details[$i]['remarks'],
                    ];
                }
            }

            if(count($dataFormat) > 0){
                HospitalFacilityDetail::insert($dataFormat);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Hospital successfully updated!']);
        } catch (\Exception $e) {

            DB::rollback();
            print_r($e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !!!!!, Please try again']);
        }
    }

    public function destroy($id)
    {
        try{

            $hospital = Hospital::FindOrFail($id);

            $cover_image = $hospital->cover_image;
            if ($cover_image) {

                //Delete old cover image
                $delete_img = 'uploads/hospital_cover_photo/'.$cover_image;

                if(file_exists(public_path($delete_img)) && $cover_image!=NULL){
                    unlink(public_path($delete_img));
                }

                $delete_thumb = 'uploads/hospital_cover_photo/thumb/'.$cover_image;

                if(file_exists(public_path($delete_thumb)) && $cover_image!=NULL){
                    unlink(public_path($delete_thumb));
                }


            }

            $logo = $hospital->logo;
            if ($logo) {

                //Delete old logo
                $delete_img = 'uploads/hospital_logo/'.$logo;

                if(file_exists(public_path($delete_img)) && $logo!=NULL){
                    unlink(public_path($delete_img));
                }

                $delete_thumb = 'uploads/hospital_logo/thumb/'.$logo;

                if(file_exists(public_path($delete_thumb)) && $logo!=NULL){
                    unlink(public_path($delete_thumb));
                }

            }

            //Delete Gallery Images
            $rows = HospitalGalleryImage::where('hospital_id', $id)->get();
            foreach ($rows as $row) {
                $delete_img = 'uploads/hospital_gallery/'.$row->picture;

                if(file_exists(public_path($delete_img)) && $row->picture!=NULL){
                    unlink(public_path($delete_img));
                }

                $delete_thumb = 'uploads/hospital_gallery/thumb/'.$row->picture;

                if(file_exists(public_path($delete_thumb)) && $row->picture!=NULL){
                    unlink(public_path($delete_thumb));
                }

                $row->delete();
            }

            HospitalFacilityDetail::where('hospital_id',$id)->delete();
            
            $hospital->delete();

            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return response()->json(['status' => 'success', 'message' => 'Hospital successfully Deleted !']);
        } elseif ($bug == 1451) {
            return response()->json(['status' => 'error', 'message' => 'This data is used another table, can not delete data']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something Error Found !, Please try again']);
        }
    }

    public function dataFormat($request, $id)
    {
        $dataFormat = [];
        $count = count($request->details);
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'hospital_id' => $id,
                'facility_id' => $request->details[$i]['facility_id'],
                'remarks' => $request->details[$i]['remarks']
            ];
        }
        return $dataFormat;
    }
    public function dataFormatGalleryFiles($files, $id)
    {
        $dataFormat = [];
        $count = count($files);
        for ($i = 0; $i < $count; $i++) {
            $dataFormat[$i] = [
                'hospital_id' => $id,
                'picture' => $files[$i],
            ];
        }
        return $dataFormat;
    }

}
