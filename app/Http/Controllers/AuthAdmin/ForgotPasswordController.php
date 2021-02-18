<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct() {
        $this->middleware('guest:admin');
    }

    public function guard() {
        return Auth::guard('admin');
    }

    //Email Form 
    public function showPasswordResetForm() {
        return view('authAdmin.password.email');
    }

    public function sendResetLinkAccount(Request $request) {
        // Validasi Email Apakah ada di database
        $this->validateEmail($request);

        // Cek apakah email exist di databese dengan broker admins
        $status = Password::broker($request->input('broker'))->sendResetLink($request->only('email'));
    
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
