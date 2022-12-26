<?php

namespace App\Http\Controllers\Admin\Plan;

use App\Http\Controllers\Controller;
use App\Models\DownloadPlan;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PlanInfo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Storage;
use Image;


class IndexController extends Controller
{
    public function index(){
        $data = [];
        $plans = Plan::all();
        if(count($plans)> 0){
            $data['plans'] = $plans;
        }
        
        return view('admin.plans.index',$data);
    }
    /**
     * Store  Plan
     */

     //resize image
    function compress($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 20);             //for jpeg or gif, it should be 0-100
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 3);
        }
        return $compress_image;
    }



    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'bath' => 'required',
            'bedroom' => 'required',
            'kitchen' => 'required',
            'toilets' => 'required',
            'living_room' => 'required',
            'verandah' => 'required',
            'store' => 'required',
            'story' => 'required',
            'sqm' => 'required',
            'length' => 'required',
            'width' => 'required',
            'featured_image' => 'required',
            'pdf' => 'required',
            
        ]);
        try{
          if($request->hasFile('featured_image')){ 
                $image_name = $request->file('featured_image')->getClientOriginalName();
                $image_path = $request->file('featured_image')->store('public/images');
                
                $jdhhd = storage_path('app/'.$image_path);

                

                $resize = $this->compress($jdhhd,$jdhhd);
                
                // $image_path = $jdhhd->store('public/images');
                // print_r($resize);die(12121);
                // unlink($jdhhd);
                $ext = $request->file('featured_image')->extension();
            }
             
            if($request->hasFile('pdf')){ 
                $pdf_name = $request->file('pdf')->getClientOriginalName();
                $pdf_path = $request->file('pdf')->store('public/images');
            }
            
            foreach($request->input('drawing_list') as $key => $value) {
                $DrawingList[]=$value;
            }
           
            $medias = array();
            if($request->hasFile('gallery_images')){ 
                foreach($request->file('gallery_images') as $k => $gallery_image) {
                    $path = $gallery_image->store('public/images');
                    $name = $gallery_image->getClientOriginalName();
                    $medias['gallery_img'][$k]['path'] = $path;
                }
            }
           
            $plan = new Plan;
            $plan->user_id = Auth::user()->id;
            $plan->name = $request->name;
            $plan->description = $request->description;
            $plan->image = $image_path;
            $plan->ext = $ext;
            $plan->bath = $request->bath;
            $plan->bedroom = $request->bedroom;
            $plan->kitchen = $request->kitchen;
            $plan->toilets = $request->toilets;
            $plan->living_room = $request->living_room;
            $plan->verandah = $request->verandah;
            $plan->store = $request->store;
            $plan->story = $request->story;
            $plan->sqm = $request->sqm;
            $plan->length = $request->length;
            $plan->width = $request->width;
            $plan->pdf = $pdf_path;
            $plan->drawing_list = implode(",",$DrawingList);

            $plan->save();

           // print_r($plan);
           // die;
            if(intval($plan->id) > 0){
                if(count($medias) > 0){
                    foreach($medias as $media){   
                        foreach($media as $doc){       
                            $plan_media = new PlanInfo;
                            $plan_media->plan_id = $plan->id;
                            $plan_media->gallery_images = $doc['path'];
                            $plan_media->save(); 
                        }
                    }
                }
                return redirect()->route('admin.plans.index')->with('success','Plan has been created successfully.');
            }
        }catch(Exception $e){
            return redirect()->route('admin.plans.index')->with('error',$e->getMessage());
        }
        
    }

    

    /**
     * Create  Plan
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Edit Plan
     */
    public function edit($id)
    {
        try{
            $data = [];
            $plan = Plan::find($id);
            if($plan){
                $data['plan'] = $plan;
            }
            $gallery_images = PlanInfo::where('plan_id',$id)->get();
            if(count($gallery_images)> 0){
                $data['gallery_images'] = $gallery_images;
            }
            return view('admin.plans.edit',$data);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'bath' => 'required',
            'bedroom' => 'required',
            'kitchen' => 'required',
            'toilets' => 'required',
            'living_room' => 'required',
            'verandah' => 'required',
            'store' => 'required',
            'story' => 'required',
            'sqm' => 'required',
            'length' => 'required',
            'width' => 'required'
        ]);
        try{

            foreach($request->input('drawing_list') as $key => $value) {
                $DrawingList[]=$value;
            }

            $plan = Plan::find($id);
            $plan->name = $request->name;
            $plan->description = $request->description;
            $plan->bath = $request->bath;
            $plan->bedroom = $request->bedroom;
            $plan->kitchen = $request->kitchen;
            $plan->toilets = $request->toilets;
            $plan->living_room = $request->living_room;
            $plan->verandah = $request->verandah;
            $plan->store = $request->store;
            $plan->story = $request->story;
            $plan->sqm = $request->sqm;
            $plan->length = $request->length;
            $plan->width = $request->width;
            $plan->drawing_list = implode(",",$DrawingList);

            if($request->hasFile('pdf')){ 
                $pdf_name = $request->file('pdf')->getClientOriginalName();
                $pdf_path = $request->file('pdf')->store('public/images');
                $plan->pdf = $pdf_path;
            }
            
            $plan->save();
            if(intval($plan->id) > 0){
                return redirect()->route('admin.plans.index')->with('success','Plan has been updated successfully');
            }
            return redirect()->route('admin.plans.index')->with('error','Plan has not updated');
        }catch(Exception $e){
            return $e->getMessage();
        }
        
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $plan = Plan::find($id);
            $plan->delete();
            return redirect()->route('admin.plans.index')->with('success','Plan has been deleted successfully');
        }catch(Exception $e){
            return redirect()->route('admin.plans.index')->with('error',$e->getMessage());
        }
       
    }

    /**
     * Update Plan Image
     */
    public function update_image(Request $request)
    {
        try{
            $request->validate([
                'edit_image' => 'required',
            ]);
            if($request->hasFile('edit_image')){ 
                    $path = $request->file('edit_image')->store('public/images');
                    $name = $request->file('edit_image')->getClientOriginalName();
            }

            $plan = Plan::find($request->plan_id);
            $plan->image = $path; 
            $plan->save();
            return redirect()->route('admin.plans.index')->with('success','Image has been updated successfully');
        }catch(Exception $e){
            return redirect()->route('admin.plans.index')->with('error',$e->getMessage());
        }
    }
    /**
     * Plan Details
     */
    public function details($id)
    {
        $data = [];
        $plan = Plan::find($id);
        if($plan){
            $data['plan'] = $plan;
        }
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
        $getPlanCount = DownloadPlan::where('user_id', Auth::user()->id)->whereBetween('created_at', [$weekStartDate, $weekEndDate])->get();
        $data['plan_count'] = $getPlanCount->count();
        $gallery_images = PlanInfo::where('plan_id',$id)->get();
        if(count($gallery_images)> 0){
            $data['gallery_images'] = $gallery_images;
        }
        $getDownloadCount = DownloadPlan::where('plan_id', $id)->get();
        $data['download_count'] = $getDownloadCount->count();
        return view('admin.plans.info',$data);
    }

    /**
     * Download Plan
     */
    public function download(Request $request)
    {
        try{
            $download_plan = new DownloadPlan();
            $download_plan->user_id = Auth::user()->id;
            $download_plan->plan_id = $request->plan_id;
            $download_plan->count = 1;
            $download_plan->save();
            if(intval($download_plan->id) > 0){
                return response()->json(['status' => '200', 'message'=> 'Plan has been downloaded successfully']);
            }
        }catch(Exception $e){
            return response()->json(['status' => '401', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Update Plan Gallery Image
    */
    public function update_gallery_image(Request $request)
    {
        try{
            $request->validate([
                'edit_gallery_image' => 'required',
            ]);
            if($request->hasFile('edit_gallery_image')){ 
                    $path = $request->file('edit_gallery_image')->store('public/images');
                    $name = $request->file('edit_gallery_image')->getClientOriginalName();
            }
            $plan_info = PlanInfo::find($request->plan_info_id);
            $plan_info->gallery_images = $path; 
            $plan_info->save();
            return redirect()->route('admin.plans.index')->with('success','Image has been updated successfully');
        }catch(Exception $e){
            return redirect()->route('admin.plans.index')->with('error',$e->getMessage());
        }
    }

    /**
     * Delete Gallery Image
     */
    public function delete_gallery_image(Request $request){
        try{
           
            $plan_gallery = PlanInfo::find($request->id);
            $plan_gallery->delete();
            return response()->json(['status' => '200', 'message'=> 'Image Deleted']);
        }catch(Exception $e){
            return response()->json(['status' => '401', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Add Gallery Images
     */
    public function add_gallery_images(Request $request)
    {
        try {
            $medias = array();
            if($request->hasFile('add_gallery_image')){ 
                foreach($request->file('add_gallery_image') as $k => $gallery_image) {
                    $path = $gallery_image->store('public/images');
                    $name = $gallery_image->getClientOriginalName();
                    $medias['gallery_img'][$k]['path'] = $path;
                }
            }
           
            if(count($medias) > 0){
                foreach($medias as $media){   
                    foreach($media as $doc){  
                        $plan_media = new PlanInfo;
                        $plan_media->plan_id = $request->add_plan_id;
                        $plan_media->gallery_images = $doc['path'];
                        $plan_media->save();   
                    }
                }
                return redirect()->route('admin.plans.index')->with('success','Image has been added successfully');
            }
        } catch (\Throwable $th) {
            return redirect()->route('admin.plans.index')->with('error',$th->getMessage());
        }
    }
}

