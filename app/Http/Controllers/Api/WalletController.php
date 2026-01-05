<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletPage;
use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * GET /api/content/wallet-page
     * Fetch wallet page content, balance, and recent transactions
     */
    public function getWalletPage()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        // Create wallet if it doesn't exist
        if (!$wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0.00,
                'points' => 0.00,
            ]);
        }

        // Get or create page content
        $pageContent = WalletPage::first();
        if (!$pageContent) {
            $pageContent = WalletPage::create([
                'text_hello' => 'Hello',
                'title_main_balance' => 'Main balance',
                'label_withdraw' => 'Withdraw',
                'label_transfer' => 'Transfer',
                'title_latest_transactions' => 'Latest Transactions',
                'button_view_all' => 'View All',
            ]);
        }

        // Get latest 3 transactions
        $transactions = $wallet->transactions()->completed()->take(3)->get();

        $formattedTransactions = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'title' => $transaction->title,
                'time' => $transaction->formatted_time,
                'amount' => number_format($transaction->amount, 2),
                'is_debited' => $transaction->is_debited,
            ];
        });

        return response()->json([
            'wallet' => $wallet->formatted_balance,
            'latest_transactions' => [
                'heading' => [
                    'main_heading' => $pageContent->title_latest_transactions,
                    'side_text' => $pageContent->button_view_all,
                ],
                'transactions' => $formattedTransactions,
            ],
            'page_content' => [
                'text_hello' => $pageContent->text_hello,
                'title_main_balance' => $pageContent->title_main_balance,
                'label_withdraw' => $pageContent->label_withdraw,
                'label_transfer' => $pageContent->label_transfer,
                'title_latest_transactions' => $pageContent->title_latest_transactions,
                'button_view_all' => $pageContent->button_view_all,
            ],
        ]);
    }

    /**
     * POST /api/wallet/withdraw
     * Withdraw funds to bank account
     */
    public function withdraw(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet not found',
            ], 404);
        }

        $request->validate([
            'amount' => 'required|numeric|min:10',
            'bank_account_id' => 'required|exists:bank_accounts,id,user_id,' . $user->id,
        ]);

        $amount = $request->amount;

        if (!$wallet->hasSufficientBalance($amount)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance',
            ], 400);
        }

        if ($amount < 10) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum withdrawal amount is $10',
            ], 400);
        }

        $bankAccount = BankAccount::find($request->bank_account_id);

        try {
            $transaction = $wallet->deductFunds(
                $amount,
                'withdrawal',
                "Withdrawal to {$bankAccount->bank_name}",
                [
                    'bank_account_id' => $bankAccount->id,
                    'bank_name' => $bankAccount->bank_name,
                    'account_number' => $bankAccount->masked_account_number,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal initiated successfully',
                'transaction' => [
                    'id' => $transaction->id,
                    'type' => 'withdrawal',
                    'amount' => number_format($transaction->amount, 2),
                    'status' => 'pending',
                    'bank_account' => $bankAccount->masked_account_number,
                    'estimated_arrival' => '2-3 business days',
                    'created_at' => $transaction->created_at->toIso8601String(),
                ],
                'new_balance' => $wallet->full_balance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * POST /api/wallet/transfer
     * Transfer funds to another user
     */
    public function transfer(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet not found',
            ], 404);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'recipient_phone' => 'required|string',
            'note' => 'nullable|string|max:255',
        ]);

        $amount = $request->amount;

        if ($request->recipient_phone === $user->phone_number) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot transfer to yourself',
            ], 400);
        }

        if (!$wallet->hasSufficientBalance($amount)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance',
            ], 400);
        }

        $recipient = User::where('phone_number', $request->recipient_phone)->first();

        if (!$recipient) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with this phone number',
            ], 404);
        }

        $recipientWallet = $recipient->wallet;

        try {
            $wallet->transferTo($recipientWallet, $amount, $request->note);

            return response()->json([
                'success' => true,
                'message' => 'Transfer completed successfully',
                'transaction' => [
                    'id' => $wallet->transactions()->latest()->first()->id,
                    'type' => 'transfer_out',
                    'amount' => number_format($amount, 2),
                    'recipient' => [
                        'name' => $recipient->name,
                        'phone' => $recipient->phone_number,
                    ],
                    'note' => $request->note,
                    'created_at' => now()->toIso8601String(),
                ],
                'new_balance' => $wallet->refresh()->full_balance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * POST /api/wallet/add-funds
     * Add funds to wallet (top-up)
     */
    public function addFunds(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0.00,
                'points' => 0.00,
            ]);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:card,paypal,google_pay,apple_pay',
            'transaction_id' => 'nullable|string',
        ]);

        try {
            $transaction = $wallet->addFunds(
                $request->amount,
                'top_up',
                'Wallet Top-up',
                [
                    'payment_method' => $request->payment_method,
                    'transaction_id' => $request->transaction_id,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Funds added successfully',
                'transaction' => [
                    'id' => $transaction->id,
                    'type' => 'top_up',
                    'amount' => number_format($transaction->amount, 2),
                    'payment_method' => $request->payment_method,
                    'created_at' => $transaction->created_at->toIso8601String(),
                ],
                'new_balance' => $wallet->full_balance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please try again.',
            ], 400);
        }
    }

    /**
     * GET /api/wallet/transactions
     * Get paginated transaction history
     */
    public function getTransactions(Request $request)
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return response()->json([
                'transactions' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 20,
                    'total' => 0,
                ],
            ]);
        }

        $perPage = $request->input('per_page', 20);
        $type = $request->input('type');

        $query = $wallet->transactions()->completed();

        if ($type) {
            $query->ofType($type);
        }

        $transactions = $query->paginate($perPage);

        $formattedTransactions = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'title' => $transaction->title,
                'time' => $transaction->formatted_time,
                'amount' => number_format($transaction->amount, 2),
                'is_debited' => $transaction->is_debited,
            ];
        });

        return response()->json([
            'transactions' => $formattedTransactions,
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }
}
