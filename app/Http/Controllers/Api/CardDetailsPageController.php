<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Card\CardResource;
use App\Models\CardDetailsPage;
use App\Http\Resources\Content\CardDetailsPageResource;
use Illuminate\Http\Request;

class CardDetailsPageController extends Controller
{
    public function getPageContent(Request $request)
    {
        $page = CardDetailsPage::where('status', true)->latest()->first();

        $pageContent = $page ? [
            'app_bar_title' => $page->title ?? 'Card Details',
            'section_title' => $page->text_add_card ?? 'Edit Credit/Debit Card',
            'add_new_text' => 'Add New',
            'card_holder_label' => "Card Holder's Name",
            'card_holder_hint' => $page->hint_card_holder ?? 'Enter Card Holder Name',
            'card_number_label' => 'Card Number',
            'card_number_hint' => $page->hint_card_number ?? 'Enter Card Number',
            'expiry_date_label' => 'Expiry Date',
            'expiry_date_hint' => $page->hint_expiry_date ?? 'MM/YY',
            'cvc_label' => 'CVC',
            'cvc_hint' => $page->hint_cvc ?? 'Enter CVC',
            'cancel_button_text' => 'Cancel',
            'save_button_text' => 'Save',
            'delete_confirm_title' => 'Delete Card',
            'delete_confirm_message' => 'Are you sure you want to delete this card?',
        ] : [
            'app_bar_title' => 'Card Details',
            'section_title' => 'Edit Credit/Debit Card',
            'add_new_text' => 'Add New',
            'card_holder_label' => "Card Holder's Name",
            'card_holder_hint' => 'Enter Card Holder Name',
            'card_number_label' => 'Card Number',
            'card_number_hint' => 'Enter Card Number',
            'expiry_date_label' => 'Expiry Date',
            'expiry_date_hint' => 'MM/YY',
            'cvc_label' => 'CVC',
            'cvc_hint' => 'Enter CVC',
            'cancel_button_text' => 'Cancel',
            'save_button_text' => 'Save',
            'delete_confirm_title' => 'Delete Card',
            'delete_confirm_message' => 'Are you sure you want to delete this card?',
        ];

        $response = [
            'page_content' => $pageContent,
            'cards' => [],
            'selected_card' => null,
        ];

        // If user is authenticated, include their cards
        if ($request->user()) {
            $cards = $request->user()->paymentCards()
                ->orderByDesc('is_default')
                ->orderByDesc('created_at')
                ->get();

            $response['cards'] = CardResource::collection($cards);
            $response['selected_card'] = $cards->firstWhere('is_default', true)
                ? new CardResource($cards->firstWhere('is_default', true))
                : ($cards->first() ? new CardResource($cards->first()) : null);
        }

        return response()->json($response);
    }
}
