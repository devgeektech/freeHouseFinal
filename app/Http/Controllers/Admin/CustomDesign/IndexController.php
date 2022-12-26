<?php

namespace App\Http\Controllers\Admin\CustomDesign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        return view('admin.custom_designs.index');
    }
}
