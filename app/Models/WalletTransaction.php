<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference_type',
        'reference_id',
        'description',
        'status',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'metadata' => 'array',
    ];

    protected $appends = [
        'is_debited',
        'formatted_time',
        'title',
    ];

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Check if this is a debit transaction.
     */
    public function getIsDebitedAttribute(): bool
    {
        return in_array($this->type, ['withdrawal', 'transfer_out', 'order']);
    }

    /**
     * Get human-readable time format.
     */
    public function getFormattedTimeAttribute(): string
    {
        $date = Carbon::parse($this->created_at);
        $now = Carbon::now();

        if ($date->isToday()) {
            return 'Today, ' . $date->format('g:i A');
        } elseif ($date->isYesterday()) {
            return 'Yesterday, ' . $date->format('g:i A');
        } else {
            return $date->format('M j, Y');
        }
    }

    /**
     * Get transaction title.
     */
    public function getTitleAttribute(): string
    {
        if ($this->description) {
            return $this->description;
        }

        return match ($this->type) {
            'top_up' => 'Wallet Top-up',
            'withdrawal' => 'Withdrawal',
            'transfer_in' => 'Money Received',
            'transfer_out' => 'Money Sent',
            'order' => 'Order Payment',
            'refund' => 'Order Refund',
            default => 'Transaction',
        };
    }

    /**
     * Scope to filter by transaction type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
