<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForgotPasswordPageResource extends JsonResource
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
            'continue_button_text' => $this->continue_button_text,
            'status' => $this->status,
        ];
    }
}
