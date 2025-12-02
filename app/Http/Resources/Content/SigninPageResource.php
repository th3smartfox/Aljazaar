<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SigninPageResource extends JsonResource
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
            'email_or_phone_label' => $this->email_or_phone_label,
            'email_or_phone_hint' => $this->email_or_phone_hint,
            'password_label' => $this->password_label,
            'password_hint' => $this->password_hint,
            'forgot_password_text' => $this->forgot_password_text,
            'login_button_text' => $this->login_button_text,
            'dont_have_account_text' => $this->dont_have_account_text,
            'sign_up_text' => $this->sign_up_text,
            'status' => $this->status,
        ];
    }
}
