<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_holder_name',
        'last_four_digits',
        'brand',
        'expiry_month',
        'expiry_year',
        'is_default',
        'stripe_payment_method_id',
        'fingerprint',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected $hidden = [
        'stripe_payment_method_id',
        'fingerprint',
    ];

    /**
     * Get the user that owns the card.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Detect card brand from card number.
     */
    public static function detectBrand(string $cardNumber): string
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);

        $patterns = [
            'visa' => '/^4/',
            'mastercard' => '/^(5[1-5]|2[2-7])/',
            'amex' => '/^3[47]/',
            'discover' => '/^(6011|64[4-9]|65)/',
            'dinersclub' => '/^(30[0-5]|36|38)/',
            'jcb' => '/^35(2[89]|[3-8][0-9])/',
            'unionpay' => '/^62/',
        ];

        foreach ($patterns as $brand => $pattern) {
            if (preg_match($pattern, $cardNumber)) {
                return $brand;
            }
        }

        return 'visa'; // Default fallback
    }

    /**
     * Generate fingerprint for duplicate detection.
     */
    public static function generateFingerprint(string $cardNumber, string $expiryMonth, string $expiryYear): string
    {
        $lastFour = substr(preg_replace('/\D/', '', $cardNumber), -4);
        return hash('sha256', $lastFour . $expiryMonth . $expiryYear);
    }

    /**
     * Validate card number using Luhn algorithm.
     */
    public static function validateLuhn(string $cardNumber): bool
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);

        if (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            return false;
        }

        $sum = 0;
        $length = strlen($cardNumber);
        $parity = $length % 2;

        for ($i = 0; $i < $length; $i++) {
            $digit = (int) $cardNumber[$i];

            if ($i % 2 === $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 === 0;
    }

    /**
     * Check if the card is expired.
     */
    public function isExpired(): bool
    {
        $expiryDate = \Carbon\Carbon::createFromFormat('m/y', $this->expiry_month . '/' . $this->expiry_year)->endOfMonth();
        return $expiryDate->isPast();
    }

    /**
     * Get formatted expiry date.
     */
    public function getFormattedExpiryAttribute(): string
    {
        return $this->expiry_month . '/' . $this->expiry_year;
    }

    /**
     * Get masked card number.
     */
    public function getMaskedNumberAttribute(): string
    {
        return '**** **** **** ' . $this->last_four_digits;
    }
}
