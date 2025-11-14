<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChangeInformationPage;
use App\Http\Resources\Content\ChangeInformationPageResource;
use Illuminate\Http\Request;

class ChangeInformationPageController extends Controller
{
    public function getPageContent(Request $request)
    {
        $page = ChangeInformationPage::where('status', true)->latest()->first();

        if (!$page) {
            $defaultData = [
                'page_content' => [
                    'title' => 'Account Settings',
                    'account' => [
                        'account_label' => 'Account',
                        'personal_information_label' => 'Personal Information',
                    ],
                    'payment' => [
                        'payment_method_label' => 'Payment Method',
                        'card_information_label' => 'Card Information',
                    ]
                ]
            ];
            return response()->json($defaultData);
        }

        return new ChangeInformationPageResource($page);
    }
}
