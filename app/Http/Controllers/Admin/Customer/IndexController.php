<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;

class IndexController extends Controller
{
    public function index(){
        $data = [];
        $customers = User::where('type','!=', 'admin')->get();
        if(count($customers)> 0){
            $data['customers'] = $customers;
        }
        return view('admin.customers.index',$data);
    }

    /**
     * Customer Details
     */
    public function details($id)
    {
        $data = [];
        $customer = User::find($id);
        if($customer){
            $data['customer'] = $customer;
        }   
        return view('admin.customers.info',$data);
    }
}
