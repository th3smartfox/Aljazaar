<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount',
        'description',
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'expiry_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get user rewards relationship.
     */
    public function userRewards(): HasMany
    {
        return $this->hasMany(UserReward::class);
    }

    /**
     * Get users who have this reward.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_rewards')
            ->withPivot('is_redeemed', 'redeemed_at')
            ->withTimestamps();
    }

    /**
     * Check if reward is expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }

    /**
     * Check if reward is valid (active and not expired).
     */
    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * Calculate discount for a given order amount.
     */
    public function calculateDiscount(float $orderAmount): float
    {
        if ($orderAmount < $this->min_order_amount) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            $discount = ($orderAmount * $this->discount_value) / 100;
            // Apply max discount cap if set
            if ($this->max_discount && $discount > $this->max_discount) {
                return (float) $this->max_discount;
            }
            return $discount;
        }

        // Fixed discount
        return min((float) $this->discount_value, $orderAmount);
    }

    /**
     * Get formatted discount display.
     */
    public function getFormattedDiscountAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '%';
        }
        return '$' . number_format($this->discount_value, 2);
    }

    /**
     * Scope for active rewards.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for non-expired rewards.
     */
    public function scopeNotExpired($query)
    {
        return $query->where('expiry_date', '>', now());
    }

    /**
     * Scope for valid rewards (active and not expired).
     */
    public function scopeValid($query)
    {
        return $query->active()->notExpired();
    }
}
