<?php

namespace App\Http\Resources\Subscription;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
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
            'plan_id' => $this->plan_id,
            'plan_name' => $this->plan_name,
            'status' => $this->status,
            'start_date' => $this->start_date->toIso8601String(),
            'end_date' => $this->end_date->toIso8601String(),
            'trial_end_date' => $this->trial_end_date?->toIso8601String(),
            'is_active' => $this->is_active,
            'is_on_trial' => $this->is_on_trial,
            'auto_renew' => $this->auto_renew,
        ];
    }
}
