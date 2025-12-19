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
        $itemData = (new ItemSummaryResource($this->whenLoaded('item')))->resolve();

        // Override item's add_ons with the selected ones from cart
        $itemData['add_ons'] = $this->cartItemAddOns->map(function ($addOn) {
            return [
                'id' => (int) $addOn->add_on_id,
                'name' => $addOn->add_on_name,
                'price' => (float) $addOn->add_on_price,
            ];
        });

        return [
            'cart_item_id' => (string) $this->id,
            'quantity' => (int) $this->quantity,
            'item' => $itemData,
        ];
    }
}