<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalInformationPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'label_name' => $this->label_name,
            'label_email' => $this->label_email,
            'label_phone' => $this->label_phone,
            'button_cancel' => $this->button_cancel,
            'button_save' => $this->button_save,
        ];
    }
}