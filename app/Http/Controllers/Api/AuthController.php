<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Usermeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request 
     * @return User 
     */
    public function registerUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'country_code' => 'required',
                'phone' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'code' => 200,
                    'message' => $validateUser->errors()->first()
                ], 200);
            }

                $user_countrycode = $request->country_code;
                $user_phone = $request->phone;
                $receiverNumber = $user_countrycode.$user_phone;
                $message = sprintf("%04d", mt_rand(1, 9999));
                $account_sid = ("AC80150ac7c975a388e48e700687df4754");
                $auth_token = ("2b8490e5e549877b0eddb697681c5ab7");
                $twilio_number = ("+14065400400");
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);
                
                $user = User::where('phone', $request->phone)->first();
               
                $user = User::updateOrCreate([
                    'id' => isset($user->id) ? $user->id : '',
                ],[
                    'country_code'=>$request->country_code,
                    'phone' => $request->phone,
                    'remember_token' => $message,
                    'type' => 'customer'
                ]);
                if($user){
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => 'Code sent successfully',
                        'data' => array('otp' =>$message,'phone' =>$request->phone),
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'code' => 200,
                        'message' => 'Something went wrong'
                    ], 200);
                }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'phone' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'code' => 200,
                    'message' => $validateUser->errors()->first()
                ], 200);
            }
            
            $credentials =  ['phone'=>$request->get('phone')];
            $user = User::where('phone', $request->phone)->first();
           
            if(!Auth::loginUsingId($user->id)){
                return response()->json([
                    'success' => false,
                    'code' => 200,
                    'message' => 'Phone does not match with our record.'
                ], 200);
            }

            
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'User Logged In Successfully',
                'data' => new UserResource($user),
                'token' => $user->createToken("authToken")->plainTextToken
            ], 200);
         
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Get The User Profile
     * @param Request $request
     * @return User
     */
    public function profileUser(Request $request)
    {
        try {
            $user = $request->user();
            if($user){
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'User Details',
                    'data' => $user,
                ], 200);
            }
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => 'No user found',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Edit User Profile
     * @param Request $request
     * @return User
     */
    public function editProfileUser(Request $request)
    {
        try {
            $user = $request->user();
            if($user){
                if(isset($request->profile_pic)){
                    $image = $request->profile_pic;  // your base64 encoded
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = time().'.'.'png';

                    // $upload = \File::put('/public/images/' . $imageName, base64_decode($image));
                    Storage::disk('devroot')->put($imageName, base64_decode($image));
                    $store_at = ('images'). '/' .$imageName; 
                }
                  
                $user->name = isset($request->name) ? $request->name : $user->name;
                $user->email = isset($request->email) ? $request->email : $user->email;
                $user->phone = isset($request->phone) ? $request->phone : $user->phone;
                $user->profile_pic = isset($store_at) ? $store_at : $user->profile_pic;
                $updated = $user->save();   
                $updated = $user->refresh();

                if($updated){
                    $response = [
                        'id' => $updated->id,
                        'name' => $updated->name,
                        'email' => $updated->email,
                        'phone' => $updated->phone,
                        'dob' => $updated->dob,
                        'profile_pic' => isset($updated->profile_pic) ? asset('public/storage/'.$updated->profile_pic) : "",
                    ];
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => 'User Details',
                        'data' => $response
                    ], 200);
                }
            }
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => 'User data not updated',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Logout API
     */

    public function logout(Request $request) 
    { 
        try {
            $user = Auth::user();
            if($user){
                auth('sanctum')->user()->tokens()->delete();
                return response()->json([
                    'code' => 200,
                    'success' => true,
                    'message' => 'User successfully signed out',
                ], 200);
            }
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Token not found',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Contact details
     */

    public function contact(Request $request)
    {
        try {
            $user = User::where('type','admin')->first();
            if($user){
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Contact Details',
                    'data' => $user,
                ], 200);
            }
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => 'No user found',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Forgot Password
     */

    public function forgot_password(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'phone' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'code' => 200,
                    'message' => $validateUser->errors()->first()
                ], 200);
            }
        try {
            $check_phone = User::where('phone',$request->phone)->first();
            if($check_phone){
               
                $user_countrycode = '91';
                $user_phone = $request->phone;
                $receiverNumber = "+ $user_countrycode $user_phone";
                $message = sprintf("%04d", mt_rand(1, 9999));
                $account_sid = ("AC80150ac7c975a388e48e700687df4754");
                $auth_token = ("2b8490e5e549877b0eddb697681c5ab7");
                $twilio_number = ("+14065400400");
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);

                $otp = User::find($check_phone->id);
                
                $otp->remember_token = $message;
                $otp->save();
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Code sent successfully',
                    'data' => array('otp' =>$message,'phone' => $user_phone),
                ], 200);
            }
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' =>'User not found',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }
    
    /**
     * Opt Verification
     */

    public function verifyOtp(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
        [
            'otp' => 'required',
            'phone' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $validateUser->errors()->first()
            ], 200);
        }
        try {
            $verify_otp = User::where('remember_token',$request->otp)->where('phone',$request->phone)->first();
            if($verify_otp){
                if(count(DB::table('personal_access_tokens')->where('tokenable_id', $verify_otp->id)->get()) > 0){
                    DB::table('personal_access_tokens')->where('tokenable_id', $verify_otp->id)->delete();
                }
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' =>'OTP verify successfully',
                     'phone' => $request->phone,
                    'token' => $verify_otp->createToken("authToken")->plainTextToken
                ], 200);
            }
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' =>'Invalid OTP',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Verify Referral Code
     */
    public function verifyReferral(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
        [
            'code' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $validateUser->errors()->first()
            ], 200);
        }
        try {
            $verify_rc = Usermeta::where('meta_key',"referral_code")->where('meta_value',$request->code)->first();
            
            if($verify_rc){
                Usermeta::where("user_id", $verify_rc->user_id)
                        ->where("meta_key","download_avail")
                        ->increment('meta_value');
                
                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' =>'Referral Code Verified'
                ], 200);
            }
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' =>'Referral code not matched',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }


    /**
     * Reset Password
     */
    public function reset_password(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'phone' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'success' => false,
                    'code' => 200,
                    'message' => $validateUser->errors()->first()
                ], 200);
            }

        try {
            $user = User::where('phone',$request->phone)->first();
            if($user){
                $reset_password = User::find($user->id);
                $reset_password->password = Hash::make($request->password);
                $reset_password->remember_token = "";
                $reset_password->save();

                return response()->json([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Password changed successfully'
                ], 200);

            }
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => 'No user found with this phone number'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    /**
     * Social Login
     */
    public function socialLoginHandler(Request $request){

        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $validator->errors()->first(),
            ], 200);
        }
       
        $firebaseToken = $request->firebase_token;
       
        try {
            //init firebase
            $firebase = (new Firebase\Factory())->withServiceAccount(public_path('firebase.json'))
                ->withDatabaseUri('freehouse-b1a84.firebaseapp.com');

            //create firebase auth
            $auth = $firebase->createAuth();

            //verify token
            try {
                $verifiedIdToken = $auth->verifyIdToken($firebaseToken);
            } catch (FailedToVerifyToken $e) {
                return response()->json([
                    'success' => false,
                    'code' => 200,
                    'message' => $e->getMessage(),
                ], 200);
            }

            $uid = $verifiedIdToken->claims()->get('sub');

            $user = $auth->getUser($uid);
           
            if ($user && !empty($user->providerData)) {
                $providerData = $user->providerData;
                $args = [
                    "email" => $providerData[0]->email,
                    "uid" => $providerData[0]->uid,
                    "provider" => $providerData[0]->providerId,
                    "device_token"=>isset($request->device_token) ? $request->device_token : '',
                ];

                $checkUser = User::where('email',$providerData[0]->email)->where('uid',$providerData[0]->uid)->where('provider',$providerData[0]->providerId)->first();
                
                if ($checkUser) {
                    $token = $checkUser->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => "User already registered",
                        'data' => $checkUser,
                        'access_token' => $token,
                        'already_register' =>  true
                    ], 200);
                } else {
                 
                    $socialData = array(
                        'name' => $providerData[0]->displayName,
                        'email' => $providerData[0]->email,
                        'uid' => $providerData[0]->uid,
                        'provider' => $providerData[0]->providerId,
                        'type' => 'customer'
                    );

                    $save_details =  User::create($socialData);
                   
                    if ($socialData) {
                        $token = $save_details->createToken('authToken')->plainTextToken;
                        return response()->json([
                            'success' => true,
                            'code' => 200,
                            'message' => "Data fetched successfully",
                            'data' => $socialData,
                            'access_token' => $token,
                            'already_register' =>  false
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'code' => 200,
                            'message' => 'There is an issue while signup',
                        ], 200);
                    }
                }
            }
        } catch (FirebaseException $e) {
            return response()->json([
                'success' => false,
                'code' => 200,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

}