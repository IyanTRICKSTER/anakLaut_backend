<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout','logoutAdmin']);
    }

    public function showLoginForm()
    {
        return view('authAdmin.login');
    }

    // Login Method
    public function login(Request $request)
    {
        // Memvalidasi Input Login
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        // Kirim pesan eror jika false
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($validator);

        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Login Attemt
        if (Auth::guard('admin')->attempt($credential, $remember=true)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->with('email', 'invalid credential');
    }

    // Admin Logout Method
    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
