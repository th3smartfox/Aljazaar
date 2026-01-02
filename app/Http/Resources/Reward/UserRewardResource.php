<?php

namespace App\Http\Resources\Reward;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRewardResource extends JsonResource
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
            'code' => $this->reward->code,
            'discount_type' => $this->reward->discount_type,
            'discount_value' => (float) $this->reward->discount_value,
            'min_order_amount' => (float) $this->reward->min_order_amount,
            'max_discount' => $this->reward->max_discount ? (float) $this->reward->max_discount : null,
            'description' => $this->reward->description,
            'expiry_date' => $this->reward->expiry_date->toIso8601String(),
            'is_redeemed' => $this->is_redeemed,
            'redeemed_at' => $this->redeemed_at?->toIso8601String(),
        ];
    }
}
