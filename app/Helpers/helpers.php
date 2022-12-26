<?php

use App\Models\Plan;
use App\Models\PlanInfo;
use App\Models\FavouritePlan;
use Illuminate\Support\Facades\Auth;
/**
 * Write code on Method
 *
 * @return response()
 */
/**
 * Get Plan Specifications by plan Id
 */
if (! function_exists('plan_specifications')) {
    function plan_specifications($id)
    {
        $get_specifications = Plan::select('bath', 'bedroom','kitchen','toilets','living_room','verandah','store','story','sqm','length','width')->where('id',$id)->get();

        return $get_specifications;
    }
}

/**
 * Get Plan gallery images by id
 */
if (! function_exists('plan_gallery_images')) {
    function plan_gallery_images($id)
    {
        $get_gallery_images = PlanInfo::where('plan_id',$id)->get();
        if($get_gallery_images){
            foreach($get_gallery_images as $images){
                $img[] = env('APP_URL').'/public'.Storage::url($images->gallery_images);
            }
        }
        return $img;
    }
}


/**
 * Get Plan like Unlike Status
 */
if (! function_exists('get_like_unlike')) {
    function get_like_unlike($id,$user_id)
    {    
        if(!empty($user_id)){
             $get_status = FavouritePlan::where('plan_id',$id)->where('user_id',$user_id)->get(); 
            // return $get_status;
            if(count($get_status) > 0)
            { 
                return '1';
            } 
        }
        return '0';
        
        
        // return $user;
        // $user = auth()->user();
        // if($user){
        //     $get_status = Plan::where('id',$id)->first();
        //     if($get_status){
        //         return $get_status->status;
        //     }
        // }else{
        //     return '0';
        // }
    }
}

