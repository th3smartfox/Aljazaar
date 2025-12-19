<?php

namespace App\Http\Resources\Items;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ItemSummaryResource extends JsonResource
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
            'name' => $this->name,
            'image_url' => $this->image ? asset(Storage::url($this->image)) : null,
            'base_price' => (float) $this->base_price,
            'discount_percent' => (float) $this->discount_percent,
            'discounted_price' => (float) $this->discounted_price,
            'category' => $this->whenLoaded('category'),
            'add_ons' => $this->addOns->map(function ($addOn) {
                return [
                    'id' => (int) $addOn->id,
                    'name' => $addOn->name,
                    'price' => (float) $addOn->price,
                ];
            }),
            'is_wishlisted' => $request->user('sanctum') ? $this->wishlists()->where('user_id', $request->user('sanctum')->id)->exists() : false,
        ];
    }
}