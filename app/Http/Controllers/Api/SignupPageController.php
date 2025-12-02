<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SignupPage;
use App\Http\Resources\Content\SignupPageResource;
use Illuminate\Http\Request;

class SignupPageController extends Controller
{

    public function getPageContent()
    {
        $page = SignupPage::where('status', true)->latest()->first();

        if (!$page) {
            return response()->json([
                'title' => 'Create Account',
                'sub_title' => 'Sign up with your details to start using Royal Butcher.',
                'full_name_label' => 'Full Name',
                'full_name_hint' => 'Enter your full name',
                'phone_number_label' => 'Phone Number',
                'phone_number_hint' => 'Enter your phone number',
                'password_label' => 'Password',
                'password_hint' => 'Enter your password',
                'sign_up_button_text' => 'Sign Up',
                'already_have_account_text' => 'Already have an account?',
                'login_button_text' => 'Log In',
            ]);
        }

        return new SignupPageResource($page);
    }
}
