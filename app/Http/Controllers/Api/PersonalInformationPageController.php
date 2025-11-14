<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformationPage;
use App\Http\Resources\Content\PersonalInformationPageResource;
use Illuminate\Http\Request;

class PersonalInformationPageController extends Controller
{
    public function getPageContent()
    {
        $page = PersonalInformationPage::where('status', true)->latest()->first();

        if (!$page) {
             return response()->json([
                'title' => 'Personal Information',
                'label_name' => 'Full name*',
                'label_email' => 'Email Address*',
                'label_phone' => 'Phone Number*',
                'button_cancel' => 'Cancel',
                'button_save' => 'Save',
            ]);
        }

        return new PersonalInformationPageResource($page);
    }
}