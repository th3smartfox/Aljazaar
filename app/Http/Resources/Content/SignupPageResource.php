<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SignupPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'full_name_label' => $this->full_name_label,
            'full_name_hint' => $this->full_name_hint,
            'phone_number_label' => $this->phone_number_label,
            'phone_number_hint' => $this->phone_number_hint,
            'password_label' => $this->password_label,
            'password_hint' => $this->password_hint,
            'sign_up_button_text' => $this->sign_up_button_text,
            'already_have_account_text' => $this->already_have_account_text,
            'login_button_text' => $this->login_button_text,
            'status' => $this->status,
        ];
    }
}
