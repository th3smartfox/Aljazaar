<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletPage;
use Illuminate\Http\Request;

class WalletPageController extends Controller
{

    public function index()
    {
        $walletPages = WalletPage::latest()->get();
        return view('dynamic_content.wallet_page.index', compact('walletPages'));
    }

    public function create()
    {
        return view('dynamic_content.wallet_page.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());
        WalletPage::create($request->all());
        return redirect()->route('wallet-pages.index')
                         ->with('success', 'Wallet Page content created successfully.');
    }

    public function show(WalletPage $walletPage)
    {
        return redirect()->route('wallet-pages.edit', $walletPage);
    }

    public function edit(WalletPage $walletPage)
    {
        return view('dynamic_content.wallet_page.edit', compact('walletPage'));
    }

    public function update(Request $request, WalletPage $walletPage)
    {
        $request->validate($this->getValidationRules());
        $walletPage->update($request->all());
        return redirect()->route('wallet-pages.index')
                         ->with('success', 'Wallet Page content updated successfully.');
    }

    public function destroy(WalletPage $walletPage)
    {
        $walletPage->delete();
        return redirect()->route('wallet-pages.index')
                         ->with('success', 'Wallet Page content deleted successfully.');
    }

    private function getValidationRules()
    {
        return [
            'text_hello' => 'required|string|max:100',
            'title_main_balance' => 'required|string|max:100',
            'label_withdraw' => 'required|string|max:100',
            'label_transfer' => 'required|string|max:100',
            'title_latest_transactions' => 'required|string|max:100',
            'button_view_all' => 'required|string|max:50',
            'status' => 'required|boolean',
        ];
    }
}