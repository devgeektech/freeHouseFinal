<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownloadPlan;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\User;


class IndexController extends Controller
{
    public function index()
    {
        $data = [];
        $users = User::where('type','!=','admin')->get();
        if(count($users)> 0){
            $data['users'] = $users->count();
        }
        $plans = Plan::all();
        if(count($plans)> 0){
            $data['plans'] = $plans->count();
        }
        $download_plans = DownloadPlan::count('id');
        if($download_plans){
            $data['download_plans'] = $download_plans;
        }
        return view('admin.index',$data);
    }
}
