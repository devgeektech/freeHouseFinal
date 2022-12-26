<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\DownloadPlan;
use App\Http\Resources\PlanResource; 
use App\Models\FavouritePlan;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;

class PlanController extends Controller
{
    public function list(Request $request)
    {
        try{
            $DownloadPlan_count = 0;
            $userData = (object) array("referral_code" => null,"download_avail" => null,"user_id" => null);  
            $post_data = $request->bearerToken();
            if (isset($post_data) && !empty($post_data)) {
                [$id, $user_token] = explode('|', $post_data, 2);
                $token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();
                $user_id = $token_data->tokenable_id;   
                $user = User::find($user_id);

                if($user == null){
                    return response()->json([
                        'code' => 200,
                        'status' => true,
                        'message' => 'Token not matched with existing user'
                    ], 200);   
                }else{ 
                    $now = Carbon::now(); 
                    $weekStartDate = $now->startOfWeek(Carbon::MONDAY)->toDateString();
                    $weekEndDate = $now->endOfWeek(Carbon::SUNDAY)->toDateString(); 
                    $DownloadPlan_count = DownloadPlan::whereBetween('created_at', [$weekStartDate, $weekEndDate]) 
                            ->where("user_id", "=", "$user_id")
                            ->count(); 

                    $usermetaData = $user->usermetas;
                    if($usermetaData){
                        $umda = array();

                        for ($i=0; $i < $usermetaData->count(); $i++) { 
                            # code...
                            $umda[$usermetaData[$i]->meta_key] = $usermetaData[$i]->meta_value; 
                        }

                        $umda["user_id"] = $user_id;
                        $userData = $umda;
                    }
                } 
            }
                
            $plans = PlanResource::collection(Plan::latest()->get());
           
            if($plans){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Plans fetched successfully',
                    "download_count" => $DownloadPlan_count,
                    "user" => $userData,
                    'data' => $plans
                ], 200);   
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => false,
                    'message' => 'No plan found.'
                    ],200);
            }
        }catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'status' =>  false,
                'message' => $e->getMessage()
            ],200);
        }
    }

    /**
     * Get Plan By Id
     */
    public function show($id)
    {
        try{
            $plan = Plan::find($id);
            if($plan){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Plan fetched successfully',
                    'data' => new PlanResource($plan)
                ], 200);   
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => false,
                    'message' => 'No plan found.'
                    ],200);
            }
        }catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'status' =>  false,
                'message' => 'Something went wrong'
            ],200);
        }
    }

    /**
     * Delete Plan
     */
    public function destroy($id)
    {
        try{
            $plan = Plan::find($id);
            $plan->delete();
            if($plan){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Plan deleted',
                    'data' => new PlanResource($plan)
                ], 200);   
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'No Plan found',
                    'data' => new PlanResource($plan)
                ], 200);  
            }
        }catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'status' =>  false,
                'message' => 'Something went wrong'
            ],200);
        }
    }

    /**
     * Plan Favourite/Unfavourite
     */
    public function fav_plan(Request $request)
    { 
        $validator = Validator::make($request->all(), [
        'plan_id' => 'required',
        ]);
        if($validator->fails()){ 
            return response()->json([
                'code' => 200,
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 200);
        }
        try{
            $user = $request->user();
            $plan = Plan::find($request->plan_id);
            if($plan){
                $get_plan = FavouritePlan::where('user_id',$user->id)->where('plan_id',$request->plan_id)->first();
                if(!$get_plan){
                    FavouritePlan::create([
                        'user_id' => $user->id,
                        'plan_id' => $request->plan_id
                    ]);
                    $plan = Plan::find($request->plan_id);
                    $plan->status = '1';
                    $plan->save();
                    return response()->json([
                        'code' => 200,
                        'status' => true,
                        'message' => 'Plan favourite successfully',
                        'data' => new PlanResource($plan)
                    ], 200);   
                }else{
                    $get_plan->delete();
                    $plan = Plan::find($request->plan_id);
                    $plan->status = '2';
                    $plan->save();
                    return response()->json([
                        'code' => 200,
                        'status' => true,
                        'message' => 'Plan unfavourite successfully',
                        'data' => new PlanResource($plan)
                    ], 200);   
                }
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => false,
                    'message' => 'No plan found.'
                    ],200);
            }
        }catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'status' =>  false,
                'message' => $e->getMessage()
            ],200);
        }
    }

    /**
     * Favourite Plans List
     */
    public function get_favourite_plans(Request $request)
    {
        try{
            $user = $request->user();
            $plans = FavouritePlan::where('user_id',$user->id)->pluck('plan_id')->toArray();
            $fav_plans = PlanResource::collection(Plan::whereIn('id',$plans)->get());
            if($fav_plans){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Favourite Plans List',
                    'data' => $fav_plans
                ], 200);   
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => false,
                    'message' => 'No plan found.'
                    ],200);
            }
        }catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'status' =>  false,
                'message' => 'Something went wrong'
            ],200);
        }
    }

    /**
     * Download a Plan
     */
    public function download_plan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
        ]);
        if($validator->fails()){ 
            return response()->json([
                'code' => 200,
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 200);
        }
        try {
            $user = $request->user();
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
            $get_plan = DownloadPlan::where('plan_id', $request->plan_id)
                            ->where("user_id", "=", $user->id)
                            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
                            ->get(); 
        
            if(count($get_plan) > 0){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Plan already downloaded',
                ], 200);   
            }
            $get_plan = Plan::where('id',$request->plan_id)->first();
            
            $getPlanCount = DownloadPlan::where('user_id', $user->id)->whereBetween('created_at', [$weekStartDate, $weekEndDate])->get();
            if(intval($getPlanCount->count()) < 3){
                $download_plan = new DownloadPlan();
                $download_plan->user_id = $user->id;
                $download_plan->plan_id = $request->plan_id;
                $download_plan->count = 1;
                $download_plan->save();
                if($download_plan){
                    return response()->json([
                        'code' => 200,
                        'status' => true,
                        'message' => 'Plan downloaded successfully',
                        'data' => $download_plan,
                        'download_link' => env('APP_URL').'/public'.Storage::url($get_plan->pdf)
                    ], 200);   
                }else{
                    return response()->json([
                        'code' => 200,
                        'status' =>  false,
                        'message' => 'Failed to download plan'
                    ],200);
                }
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'You can download only 3 plans per week',
                ], 200);   
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 200,
                'status' =>  false,
                'message' => 'Something went wrong'
            ],200);
        }
    }
    
    /**
     * Get Downloaded Plans
     */
    public function get_downloaded_plans(Request $request)
    {
        try {
            $user = $request->user();
            $plans = DownloadPlan::where('user_id',$user->id)->pluck('plan_id')->toArray();
            $downloaded_plans = PlanResource::collection(Plan::whereIn('id',$plans)->get());
            if($downloaded_plans){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'message' => 'Downloaded Plans List',
                    'data' => $downloaded_plans
                ], 200);   
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => false,
                    'message' => 'No plan found.'
                    ],200);
            }
        }catch (\Throwable $e) {
            return response()->json([
                'code' => 200,
                'status' =>  false,
                'message' => 'Something went wrong'
            ],200);
        }
    }
}


