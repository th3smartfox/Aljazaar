<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChangeInformationPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'page_content' => [
                'title' => $this->title,
                'account' => [
                    'account_label' => $this->label_account,
                    'personal_information_label' => $this->label_personal_information,
                ],
                'payment' => [
                    'payment_method_label' => $this->label_payment_method,
                    'card_information_label' => $this->label_card_information,
                ]
            ]
        ];
    }
}
