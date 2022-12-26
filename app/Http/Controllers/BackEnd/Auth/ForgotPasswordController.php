<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

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

    /**
     * Show Password Reset Form
     */
    public function showLinkRequestForm()
    {
        return view('backEnd.admin.auth.passwords.email');
    }

    /**
     * @Overwrite Broker
     * Select Password Reset Broker
     */
    public function broker()
    {
        return Password::broker('admins');
    }
}
