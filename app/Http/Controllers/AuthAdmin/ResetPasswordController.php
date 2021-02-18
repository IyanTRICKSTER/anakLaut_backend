<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/admin';

    public function __construct() {
        $this->middleware('guest:admin');
    }

    public function guard() {
        return Auth::guard('admin');
    }

    public function broker() {
        return Password::broker('admins');
    }

    public function showResetForm(Request $request) {

        $token = $request->route()->parameter('token');
        
        return view('authAdmin.password.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
