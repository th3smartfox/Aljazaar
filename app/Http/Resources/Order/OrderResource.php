<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'total_amount' => (float) $this->total_amount,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'order_date' => $this->created_at->format('d M, Y h:i A'),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}