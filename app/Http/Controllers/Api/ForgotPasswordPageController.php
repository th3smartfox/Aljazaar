<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ForgotPasswordPage;
use App\Http\Resources\Content\ForgotPasswordPageResource;
use Illuminate\Http\Request;

class ForgotPasswordPageController extends Controller
{

    public function getPageContent()
    {
        $page = ForgotPasswordPage::where('status', true)->latest()->first();

        if (!$page) {
            return response()->json([
                'title' => 'Forgot Password',
                'sub_title' => 'Enter Your email or phone number to receive a verification code.',
                'email_or_phone_label' => 'Email or Phone Number',
                'email_or_phone_hint' => 'Your Email Or Phone Number',
                'continue_button_text' => 'Continue',
            ]);
        }

        return new ForgotPasswordPageResource($page);
    }
}
