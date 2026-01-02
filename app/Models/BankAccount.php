<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_holder_name',
        'routing_number',
        'is_default',
        'is_verified',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_verified' => 'boolean',
    ];

    protected $appends = [
        'masked_account_number',
    ];

    protected $hidden = [
        'account_number',
        'routing_number',
    ];

    /**
     * Get the user that owns the bank account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get masked account number (e.g., ****1234).
     */
    public function getMaskedAccountNumberAttribute(): string
    {
        if (strlen($this->account_number) < 4) {
            return '****';
        }

        return '****' . substr($this->account_number, -4);
    }

    /**
     * Set this account as default.
     */
    public function setAsDefault()
    {
        // Remove default from other accounts
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this as default
        $this->update(['is_default' => true]);
    }

    /**
     * Scope to get verified accounts.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope to get default account.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
