<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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
                ->withErrors(array('invalid' => 'Fields are empty!'))
                ->withInput();
        }

        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $rememberMe = !empty($request->remember) ? TRUE : FALSE;

        // Login Attempt
        if (Auth::guard('admin')->attempt($credential, $rememberMe)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(array('invalid' => 'Invalid credentials'));
        // return "incorect password";
    }

    // Admin Logout Method
    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
