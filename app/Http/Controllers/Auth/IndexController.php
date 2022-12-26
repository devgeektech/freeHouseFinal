<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class IndexController extends Controller
{
    /**
     * Login
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }else{
            return back()->with("errors", "Email or password incorrect!");
        }
    }

    /**
     * Update password
     */
    public function update_password(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        $user = User::where('email', Auth::user()->email)->first();
        if($user){
            $user->password = Hash::make($request->password);
            $user->save();
            if(intval($user->id) > 0){
                return redirect()->route('admin.profile-settings')->with('password_success','Password Changed successfully.');
            }
        }
    }

    /**
     * Get Profile Settings
     */

    public function profile_settings()
    {  
        $data = [];
        $user = User::where('email', Auth::user()->email)->first();
        $data['user'] = $user;
        if(Auth::user()){
            return view('admin.profile.update', $data);
        }
    }

    /**
     * Update Profile
     */
    public function update_profile(Request $request)
    {
        $user = User::where('email', Auth::user()->email)->first();
        if($request->profile_picture){ 
            $path = $request->profile_picture->store('public/images');
            $profile_picture = $path;
        }else{
            $profile_picture = Auth::user()->profile_pic;
        }
        if($user){
            $user->name = isset($request->name) ? $request->name : Auth::user()->name;
            $user->email = isset($request->email) ? $request->email : Auth::user()->email;
            $user->phone = isset($request->phone) ? $request->phone : Auth::user()->phone;
            $user->profile_pic = $profile_picture;
            $user->save();
            if(intval($user->id) > 0){
                    return redirect()->route('admin.profile-settings')->with('username_success','Profile Updated successfully.');
            }
        }
    }
    
    /**
     * Logout
     */
    public function logout(Request $request) 
    {
        Auth::logout();
        return redirect('/');
    }

    
}
