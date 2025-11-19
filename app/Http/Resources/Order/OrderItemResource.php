<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Items\ItemSummaryResource; // Item module ka resource

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'quantity' => $this->quantity,
            'price_at_purchase' => (float) $this->price_at_purchase,
            'selected_add_ons' => $this->selected_add_ons,
            'item' => new ItemSummaryResource($this->whenLoaded('item')),
        ];
    }
}