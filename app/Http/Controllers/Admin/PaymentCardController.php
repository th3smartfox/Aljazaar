<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentCard;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentCardController extends Controller
{
    /**
     * Display a listing of all payment cards.
     */
    public function index(Request $request)
    {
        $query = PaymentCard::with('user')
            ->orderByDesc('created_at');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Search by card holder name or last 4 digits
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('card_holder_name', 'like', "%{$search}%")
                    ->orWhere('last_four_digits', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $cards = $query->paginate(15)->withQueryString();

        return view('admin.payment-cards.index', compact('cards'));
    }

    /**
     * Display cards for a specific user.
     */
    public function userCards(User $user)
    {
        $cards = $user->paymentCards()
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.payment-cards.user-cards', compact('user', 'cards'));
    }

    /**
     * Remove the specified card.
     */
    public function destroy(PaymentCard $paymentCard)
    {
        $userName = $paymentCard->user->name ?? 'Unknown';
        $lastFour = $paymentCard->last_four_digits;

        $paymentCard->delete();

        return redirect()->back()
            ->with('success', "Card ending in {$lastFour} for {$userName} has been deleted.");
    }

    /**
     * Toggle default status for a card.
     */
    public function toggleDefault(PaymentCard $paymentCard)
    {
        if ($paymentCard->is_default) {
            // If already default, just unset it
            $paymentCard->update(['is_default' => false]);
            $message = 'Card is no longer the default.';
        } else {
            // Unset all other defaults for this user
            PaymentCard::where('user_id', $paymentCard->user_id)
                ->where('id', '!=', $paymentCard->id)
                ->update(['is_default' => false]);

            // Set this card as default
            $paymentCard->update(['is_default' => true]);
            $message = 'Card set as default successfully.';
        }

        return redirect()->back()->with('success', $message);
    }
}
