<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'points',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'points' => 'decimal:2',
    ];

    protected $appends = [
        'formatted_balance',
        'full_balance',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all transactions for this wallet.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class)->latest();
    }

    /**
     * Get formatted balance (e.g., "125" + ".50" = "$125.50")
     */
    public function getFormattedBalanceAttribute()
    {
        $integerPart = floor($this->balance);
        $decimalPart = number_format($this->balance - $integerPart, 2);

        return [
            'balance' => (string) $integerPart,
            'points' => substr($decimalPart, 1), // e.g., ".50"
        ];
    }

    /**
     * Get full balance as decimal.
     */
    public function getFullBalanceAttribute()
    {
        return number_format((float) $this->balance, 2, '.', '');
    }

    /**
     * Add funds to wallet.
     */
    public function addFunds(float $amount, string $type, string $description, ?array $metadata = null)
    {
        return DB::transaction(function () use ($amount, $type, $description, $metadata) {
            $balanceBefore = $this->balance;
            $this->increment('balance', $amount);
            $this->refresh();

            return $this->transactions()->create([
                'type' => $type,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $this->balance,
                'description' => $description,
                'status' => 'completed',
                'metadata' => $metadata ? json_encode($metadata) : null,
            ]);
        });
    }

    /**
     * Deduct funds from wallet.
     */
    public function deductFunds(float $amount, string $type, string $description, ?array $metadata = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        return DB::transaction(function () use ($amount, $type, $description, $metadata) {
            $balanceBefore = $this->balance;
            $this->decrement('balance', $amount);
            $this->refresh();

            return $this->transactions()->create([
                'type' => $type,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $this->balance,
                'description' => $description,
                'status' => 'completed',
                'metadata' => $metadata ? json_encode($metadata) : null,
            ]);
        });
    }

    /**
     * Transfer funds to another wallet.
     */
    public function transferTo(Wallet $recipientWallet, float $amount, ?string $note = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        return DB::transaction(function () use ($recipientWallet, $amount, $note) {
            // Deduct from sender
            $this->deductFunds(
                $amount,
                'transfer_out',
                "Transfer to {$recipientWallet->user->name}",
                [
                    'recipient_user_id' => $recipientWallet->user_id,
                    'recipient_name' => $recipientWallet->user->name,
                    'note' => $note,
                ]
            );

            // Add to recipient
            $recipientWallet->addFunds(
                $amount,
                'transfer_in',
                "Transfer from {$this->user->name}",
                [
                    'sender_user_id' => $this->user_id,
                    'sender_name' => $this->user->name,
                    'note' => $note,
                ]
            );

            return true;
        });
    }

    /**
     * Check if wallet has sufficient balance.
     */
    public function hasSufficientBalance(float $amount): bool
    {
        return $this->balance >= $amount;
    }
}
