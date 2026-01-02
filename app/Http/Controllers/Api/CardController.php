<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Card\CardResource;
use App\Models\PaymentCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    /**
     * Get all saved cards for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $cards = $request->user()->paymentCards()
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'cards' => CardResource::collection($cards),
        ]);
    }

    /**
     * Store a new payment card.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'card_holder_name' => 'required|string|min:2|max:100',
            'card_number' => [
                'required',
                'string',
                'min:13',
                'max:19',
                function ($attribute, $value, $fail) {
                    $cleanNumber = preg_replace('/\D/', '', $value);
                    if (!PaymentCard::validateLuhn($cleanNumber)) {
                        $fail('Please enter a valid card number.');
                    }
                },
            ],
            'expiry_month' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])$/'],
            'expiry_year' => [
                'required',
                'string',
                'regex:/^\d{2}$/',
                function ($attribute, $value, $fail) use ($request) {
                    $month = $request->input('expiry_month');
                    $year = $value;

                    if ($month && $year) {
                        $expiryDate = \Carbon\Carbon::createFromFormat('m/y', $month . '/' . $year)->endOfMonth();
                        if ($expiryDate->isPast()) {
                            $fail('The card has expired.');
                        }
                    }
                },
            ],
            'cvc' => 'required|string|min:3|max:4',
            'is_default' => 'sometimes|boolean',
        ]);

        $cardNumber = preg_replace('/\D/', '', $validated['card_number']);
        $lastFourDigits = substr($cardNumber, -4);
        $brand = PaymentCard::detectBrand($cardNumber);
        $fingerprint = PaymentCard::generateFingerprint(
            $cardNumber,
            $validated['expiry_month'],
            $validated['expiry_year']
        );

        // Check for duplicate card
        $existingCard = $request->user()->paymentCards()
            ->where('fingerprint', $fingerprint)
            ->first();

        if ($existingCard) {
            return response()->json([
                'success' => false,
                'message' => 'This card is already saved',
            ], 400);
        }

        $isDefault = $validated['is_default'] ?? false;

        DB::transaction(function () use ($request, $validated, $lastFourDigits, $brand, $fingerprint, &$card, $isDefault) {
            // If this card should be default, unset others
            if ($isDefault) {
                $request->user()->paymentCards()->update(['is_default' => false]);
            }

            // If this is the first card, make it default
            $isFirstCard = $request->user()->paymentCards()->count() === 0;

            $card = $request->user()->paymentCards()->create([
                'card_holder_name' => $validated['card_holder_name'],
                'last_four_digits' => $lastFourDigits,
                'brand' => $brand,
                'expiry_month' => $validated['expiry_month'],
                'expiry_year' => $validated['expiry_year'],
                'is_default' => $isDefault || $isFirstCard,
                'fingerprint' => $fingerprint,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Card added successfully',
            'card' => new CardResource($card),
        ], 201);
    }

    /**
     * Update an existing card.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $card = $request->user()->paymentCards()->find($id);

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'Card not found',
            ], 404);
        }

        $validated = $request->validate([
            'card_holder_name' => 'required|string|min:2|max:100',
            'expiry_month' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])$/'],
            'expiry_year' => [
                'required',
                'string',
                'regex:/^\d{2}$/',
                function ($attribute, $value, $fail) use ($request) {
                    $month = $request->input('expiry_month');
                    $year = $value;

                    if ($month && $year) {
                        $expiryDate = \Carbon\Carbon::createFromFormat('m/y', $month . '/' . $year)->endOfMonth();
                        if ($expiryDate->isPast()) {
                            $fail('The card has expired.');
                        }
                    }
                },
            ],
        ]);

        $card->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Card updated successfully',
            'card' => new CardResource($card->fresh()),
        ]);
    }

    /**
     * Delete a saved card.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $card = $request->user()->paymentCards()->find($id);

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'Card not found',
            ], 404);
        }

        // Check if trying to delete default card when other cards exist
        if ($card->is_default) {
            $otherCardsCount = $request->user()->paymentCards()->where('id', '!=', $id)->count();
            if ($otherCardsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete default card. Set another card as default first.',
                ], 400);
            }
        }

        $card->delete();

        return response()->json([
            'success' => true,
            'message' => 'Card deleted successfully',
        ]);
    }

    /**
     * Set a card as the default payment method.
     */
    public function setDefault(Request $request, int $id): JsonResponse
    {
        $card = $request->user()->paymentCards()->find($id);

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'Card not found',
            ], 404);
        }

        DB::transaction(function () use ($request, $card) {
            // Unset all defaults for this user
            $request->user()->paymentCards()->update(['is_default' => false]);

            // Set this card as default
            $card->update(['is_default' => true]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Default card updated',
            'card' => new CardResource($card->fresh()),
        ]);
    }
}
