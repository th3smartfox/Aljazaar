<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address_title' => $this->address_title,
            'address' => $this->address_line,
            'street_number' => $this->street_number,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'landmark' => $this->landmark,
            'nearest_landmark' => $this->nearest_landmark,
            'city_id' => $this->city_id,
            'city' => $this->whenLoaded('city'),
            'is_default' => (bool) $this->is_default,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
