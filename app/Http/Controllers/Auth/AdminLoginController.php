<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // only logged out visitor can have access
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $this->validate($request,
            [
                'email'=>'required|email|string',
                'password'=>'required|string|min:8'
            ],
        );

        // attempt to login as admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if success, redirect to intended route or dashboard
            return redirect()->intended(route('admin.dashboard', app()->getLocale()));
        }

        // if failed, redirect to login page with remember fields
        return redirect()->back()->with($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
