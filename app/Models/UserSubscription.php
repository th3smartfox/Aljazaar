<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'start_date',
        'end_date',
        'trial_end_date',
        'auto_renew',
        'cancelled_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'trial_end_date' => 'datetime',
        'cancelled_at' => 'datetime',
        'auto_renew' => 'boolean',
    ];

    protected $appends = [
        'is_active',
        'is_on_trial',
        'plan_name',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    /**
     * Check if subscription is currently active.
     */
    public function getIsActiveAttribute(): bool
    {
        return in_array($this->status, ['trial', 'active', 'cancelled'])
            && $this->end_date->isFuture();
    }

    /**
     * Check if subscription is on trial.
     */
    public function getIsOnTrialAttribute(): bool
    {
        return $this->status === 'trial'
            && $this->trial_end_date
            && $this->trial_end_date->isFuture();
    }

    /**
     * Get the plan name.
     */
    public function getPlanNameAttribute(): ?string
    {
        return $this->plan?->name;
    }

    /**
     * Scope to get active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['trial', 'active', 'cancelled'])
            ->where('end_date', '>', now());
    }

    /**
     * Scope to get expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'expired')
              ->orWhere('end_date', '<=', now());
        });
    }

    /**
     * Scope to get subscriptions on trial.
     */
    public function scopeOnTrial($query)
    {
        return $query->where('status', 'trial')
            ->whereNotNull('trial_end_date')
            ->where('trial_end_date', '>', now());
    }

    /**
     * Cancel the subscription.
     */
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'auto_renew' => false,
        ]);
    }

    /**
     * Convert trial to active (when trial ends or payment confirmed).
     */
    public function activateFromTrial()
    {
        if ($this->status === 'trial') {
            $this->update(['status' => 'active']);
        }
    }

    /**
     * Mark subscription as expired.
     */
    public function expire()
    {
        $this->update(['status' => 'expired']);
    }
}
