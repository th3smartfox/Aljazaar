<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Items\ItemSummaryResource; // Humara purana Item resource

class CartResource extends JsonResource
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
            'quantity' => (int) $this->quantity,
            'item' => new ItemSummaryResource($this->whenLoaded('item')),
        ];
    }
}