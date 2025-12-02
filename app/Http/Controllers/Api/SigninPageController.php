<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SigninPage;
use App\Http\Resources\Content\SigninPageResource;
use Illuminate\Http\Request;

class SigninPageController extends Controller
{

    public function getPageContent()
    {
        $page = SigninPage::where('status', true)->latest()->first();

        if (!$page) {
            return response()->json([
                'title' => 'Welcome Back',
                'sub_title' => 'Login with your email or phone number to continue.',
                'email_or_phone_label' => 'Email or Phone Number',
                'email_or_phone_hint' => 'Enter your email or phone number',
                'password_label' => 'Password',
                'password_hint' => 'Your Password',
                'forgot_password_text' => 'Forgot Password?',
                'login_button_text' => 'Login',
                'dont_have_account_text' => "Don't have an account?",
                'sign_up_text' => 'Sign Up',
            ]);
        }

        return new SigninPageResource($page);
    }
}
