<?php

namespace App\Http\Resources\Subscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPlanResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'discount_per_order' => $this->discount_per_order,
            'duration_days' => $this->duration_days,
            'trial_days' => $this->trial_days,
            'badge' => $this->badge,
            'is_recommended' => $this->is_recommended,
        ];
    }
}
