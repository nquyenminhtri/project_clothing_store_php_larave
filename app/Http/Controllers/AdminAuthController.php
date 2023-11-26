<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AdminAuthController extends Controller
{
    public function indexLogin(){
        return view('Auth/Admin/login');
    }
    public function handleLogin(Request $request)
    {
        // Check login infomation
        $credentials = $request->only('user_name', 'password');
        // Login with guard admin
        if (Auth::guard('admin')->attempt($credentials)) {
            // Login successfully
            $user = Auth::guard('admin')->user();

            $request->session()->put('adminAccount',$user);
            
            return redirect()->route('layout');
        }
        // Login failed
        return redirect()->route('admin.login')->with('status', 'Login unsuccessful');
    }

    public function handleLogout()
    {
        Auth::guard('admin')->logout();
        // Navigation to login when logout successfully
        return redirect()->route('admin.login');
    }
    
}