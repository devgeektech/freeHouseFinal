<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth 
Route::group(['prefix'=>'auth', 'as'=>'auth.'], function(){
    Route::post('register', [AuthController::class, 'registerUser']);
    Route::post('login', [AuthController::class, 'loginUser']);
    Route::get('profile', [AuthController::class, 'profileUser'])->middleware('auth:sanctum');
    Route::post('profile/update', [AuthController::class, 'editProfileUser'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware("auth:sanctum");
    Route::get('contact', [AuthController::class, 'contact'])->middleware('auth:sanctum');
    Route::post('forgot_password', [AuthController::class, 'forgot_password']);
    Route::post('verifyOtp',[AuthController::class, 'verifyOtp']);
    Route::post('reset_password',[AuthController::class,'reset_password']);
    Route::post('social_login',[AuthController::class,'socialLoginHandler']);
    Route::post('current_token', [AuthController::class, 'get_latest_token']);


    Route::post('verify-referral', [AuthController::class, 'verifyReferral'])->middleware("auth:sanctum");
});

Route::group(['prefix' => 'plans','as' => 'plans.'], function () {
    Route::get('/list', [PlanController::class, 'list'])->name('list');
    Route::get('/show/{id}', [PlanController::class, 'show'])->name('show');
    Route::post('/destroy/{id}', [PlanController::class, 'destroy'])->name('destroy')->middleware('auth:sanctum');
    Route::post('/make_fav', [PlanController::class, 'fav_plan'])->name('fav_plan')->middleware('auth:sanctum');
    Route::get('/favourite', [PlanController::class, 'get_favourite_plans'])->name('fav_plans')->middleware('auth:sanctum');
    Route::get('/downloads', [PlanController::class, 'get_downloaded_plans'])->name('downloads')->middleware('auth:sanctum');  
    Route::post('/download', [PlanController::class, 'download_plan'])->name('download')->middleware('auth:sanctum');
    
});

Route::group(['prefix' => 'users','as' => 'users.'], function () {
    Route::get('/list', [UserController::class, 'list'])->name('list')->middleware('auth:sanctum');
    Route::get('/show/{id}', [UserController::class, 'show'])->name('show')->middleware('auth:sanctum');
});

