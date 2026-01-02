<?php

namespace App\Http\Resources\Reward;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RewardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Check if this is from user_rewards pivot or direct reward
        $isRedeemed = false;
        $redeemedAt = null;

        if ($this->pivot) {
            $isRedeemed = (bool) $this->pivot->is_redeemed;
            $redeemedAt = $this->pivot->redeemed_at;
        } elseif ($this->resource instanceof \App\Models\UserReward) {
            $isRedeemed = $this->is_redeemed;
            $redeemedAt = $this->redeemed_at;
            // Get the actual reward data
            $reward = $this->reward;
            return [
                'id' => $this->id,
                'code' => $reward->code,
                'discount_type' => $reward->discount_type,
                'discount_value' => (float) $reward->discount_value,
                'min_order_amount' => (float) $reward->min_order_amount,
                'max_discount' => $reward->max_discount ? (float) $reward->max_discount : null,
                'description' => $reward->description,
                'expiry_date' => $reward->expiry_date->toIso8601String(),
                'is_redeemed' => $isRedeemed,
                'redeemed_at' => $redeemedAt?->toIso8601String(),
            ];
        }

        return [
            'id' => $this->id,
            'code' => $this->code,
            'discount_type' => $this->discount_type,
            'discount_value' => (float) $this->discount_value,
            'min_order_amount' => (float) $this->min_order_amount,
            'max_discount' => $this->max_discount ? (float) $this->max_discount : null,
            'description' => $this->description,
            'expiry_date' => $this->expiry_date->toIso8601String(),
            'is_redeemed' => $isRedeemed,
            'redeemed_at' => $redeemedAt?->toIso8601String(),
        ];
    }
}
