<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::with('user')->latest()->get();
        return view('admin.wallet.index', compact('wallets'));
    }

    public function show($userId)
    {
        $user = User::with('wallet.transactions')->findOrFail($userId);
        $wallet = $user->wallet;
        return view('admin.wallet.show', compact('user', 'wallet'));
    }

    public function transactions()
    {
        $transactions = WalletTransaction::with('wallet.user')->latest()->paginate(50);
        return view('admin.wallet.transactions', compact('transactions'));
    }

    public function adjustBalance(Request $request, $userId)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:add,deduct',
            'description' => 'required|string',
        ]);

        $user = User::findOrFail($userId);
        $wallet = $user->wallet;

        if ($request->type === 'add') {
            $wallet->addFunds($request->amount, 'top_up', $request->description, ['admin_adjustment' => true]);
        } else {
            $wallet->deductFunds($request->amount, 'withdrawal', $request->description, ['admin_adjustment' => true]);
        }

        return redirect()->back()->with('success', 'Wallet balance adjusted successfully.');
    }
}
