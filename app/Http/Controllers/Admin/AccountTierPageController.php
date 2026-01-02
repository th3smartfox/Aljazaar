<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountTierPage;
use Illuminate\Http\Request;

class AccountTierPageController extends Controller
{
    public function index()
    {
        $pages = AccountTierPage::latest()->get();
        return view('admin.dynamic_content.account_tier_page.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.dynamic_content.account_tier_page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'app_bar_title' => 'required|string',
            'header_image' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'button_text' => 'required|string',
            'terms_text' => 'nullable|string',
            'terms_of_service_text' => 'required|string',
            'privacy_policy_text' => 'required|string',
            'renewal_notice' => 'nullable|string',
        ]);

        AccountTierPage::create($request->all());

        return redirect()->route('account-tier-pages.index')
            ->with('success', 'Account tier page created successfully.');
    }

    public function edit(AccountTierPage $accountTierPage)
    {
        return view('admin.dynamic_content.account_tier_page.edit', compact('accountTierPage'));
    }

    public function update(Request $request, AccountTierPage $accountTierPage)
    {
        $request->validate([
            'app_bar_title' => 'required|string',
            'header_image' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'button_text' => 'required|string',
            'terms_text' => 'nullable|string',
            'terms_of_service_text' => 'required|string',
            'privacy_policy_text' => 'required|string',
            'renewal_notice' => 'nullable|string',
        ]);

        $accountTierPage->update($request->all());

        return redirect()->route('account-tier-pages.index')
            ->with('success', 'Account tier page updated successfully.');
    }

    public function destroy(AccountTierPage $accountTierPage)
    {
        $accountTierPage->delete();

        return redirect()->route('account-tier-pages.index')
            ->with('success', 'Account tier page deleted successfully.');
    }
}
