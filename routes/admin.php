<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Admin\Goal\IndexController;

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
| Here are the routes using for only admin panel
|
*/

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'

], function ($router) {
    Route::group(['middleware' => ['auth:sanctum','admin']], function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\IndexController::class,'index'])->name('dashboard');
        Route::get('/profile_settings', [App\Http\Controllers\Auth\IndexController::class,'profile_settings'])->name('profile-settings');
        Route::post('/update_password', [App\Http\Controllers\Auth\IndexController::class,'update_password'])->name('password_reset');
        Route::post('/update_profile', [App\Http\Controllers\Auth\IndexController::class,'update_profile'])->name('update-profile');
        
        Route::group(['prefix' => 'plans','as' => 'plans.'], function ($router) {
            Route::get('/', [App\Http\Controllers\Admin\Plan\IndexController::class,'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\Plan\IndexController::class,'create'])->name('create');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\Plan\IndexController::class,'edit'])->name('edit');
            Route::post('/update/{id}', [App\Http\Controllers\Admin\Plan\IndexController::class,'update'])->name('update');
            Route::post('/store', [App\Http\Controllers\Admin\Plan\IndexController::class,'store'])->name('store');
            Route::post('/destroy/{id}', [App\Http\Controllers\Admin\Plan\IndexController::class,'destroy'])->name('destroy');
            Route::post('/update_image', [App\Http\Controllers\Admin\Plan\IndexController::class,'update_image'])->name('update_image');
            Route::get('/details/{id}', [App\Http\Controllers\Admin\Plan\IndexController::class,'details'])->name('details');
            Route::post('/download', [App\Http\Controllers\Admin\Plan\IndexController::class,'download'])->name('download');
            Route::post('/update_gallery_image', [App\Http\Controllers\Admin\Plan\IndexController::class,'update_gallery_image'])->name('update_gallery_image');
            Route::post('/delete_gallery_image', [App\Http\Controllers\Admin\Plan\IndexController::class,'delete_gallery_image'])->name('delete_gallery_image');
            Route::post('/add_gallery_images', [App\Http\Controllers\Admin\Plan\IndexController::class,'add_gallery_images'])->name('add_gallery_images');
            
            
            
        });

        Route::group(['prefix' => 'customers','as' => 'customers.'], function ($router) {
            Route::get('/', [App\Http\Controllers\Admin\Customer\IndexController::class,'index'])->name('index');
            Route::get('/details/{id}', [App\Http\Controllers\Admin\Customer\IndexController::class,'details'])->name('details');
        });

        Route::group(['prefix' => 'custom_designs','as' => 'custom_designs.'], function ($router) {
            Route::get('/', [App\Http\Controllers\Admin\CustomDesign\IndexController::class,'index'])->name('index');
            Route::get('/details/{id}', [App\Http\Controllers\Admin\CustomDesign\IndexController::class,'details'])->name('details');
        });

        Route::group(['prefix' => 'advertisements','as' => 'advertisements.'], function ($router) {
            Route::get('/', [App\Http\Controllers\Admin\Advertisement\IndexController::class,'index'])->name('index');
            Route::get('/details/{id}', [App\Http\Controllers\Admin\Advertisement\IndexController::class,'details'])->name('details');
        });
    });
    
});