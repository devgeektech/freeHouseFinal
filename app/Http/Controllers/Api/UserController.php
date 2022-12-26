<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function list()
    {
        try{
            $users = UserResource::collection(User::where('type','!=', 'admin')->latest()->get());
            if($users){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $users
                ], 200);   
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => false,
                    'message' => 'No user found.'
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
     * Get Plan By Id
     */
    public function show($id)
    {
        try{
            $user = User::find($id);
            if($user){
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => new UserResource($user)
                ], 200);   
            }else{
                return response()->json([
                    'code' => 200,
                    'status' => false,
                    'message' => 'No user found.'
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
