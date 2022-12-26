<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [App\Http\Controllers\IndexController::class,'index'])->name('index');
Route::post('/login',[App\Http\Controllers\Auth\IndexController::class,'login'])->name('login');
Route::post('logout', [App\Http\Controllers\Auth\IndexController::class,'logout'])->name('logout');

Route::any('/non_authenticated', function () {
    return response()->json([
        'code' => 200,
         'status' => false,
        'message' => 'invalidToken',
    ], 200);
})->name('non_authenticated');