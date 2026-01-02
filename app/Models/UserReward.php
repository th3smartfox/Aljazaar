<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_id',
        'is_redeemed',
        'redeemed_at',
    ];

    protected $casts = [
        'is_redeemed' => 'boolean',
        'redeemed_at' => 'datetime',
    ];

    /**
     * Get the user that owns this reward.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reward.
     */
    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }

    /**
     * Mark the reward as redeemed.
     */
    public function markAsRedeemed(): bool
    {
        return $this->update([
            'is_redeemed' => true,
            'redeemed_at' => now(),
        ]);
    }

    /**
     * Check if reward can be redeemed.
     */
    public function canRedeem(): bool
    {
        return !$this->is_redeemed && $this->reward->isValid();
    }

    /**
     * Scope for redeemed rewards.
     */
    public function scopeRedeemed($query)
    {
        return $query->where('is_redeemed', true);
    }

    /**
     * Scope for available (not redeemed) rewards.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_redeemed', false);
    }
}
