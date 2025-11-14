<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WalletPage;
use App\Http\Resources\Content\WalletPageResource;
use Illuminate\Http\Request;

class WalletPageController extends Controller
{
    public function getPageContent()
    {
        $page = WalletPage::where('status', true)->latest()->first();

        // Static wallet data (will be dynamic when wallet module is ready)
        $wallet = [
            'balance' => '11,23',
            'points' => '.34',
        ];

        // Static transactions data (will be dynamic when transactions module is ready)
        $transactions = [
            [
                'id' => 1,
                'title' => 'Order Number',
                'time' => 'Today, 12:32',
                'amount' => '35.23',
                'is_debited' => true,
            ],
            [
                'id' => 2,
                'title' => 'Redeem Reward',
                'time' => 'Yesterday, 02:12',
                'amount' => '430.00',
                'is_debited' => false,
            ],
            [
                'id' => 3,
                'title' => 'Order Number',
                'time' => 'Dec 24, 13:53',
                'amount' => '13.00',
                'is_debited' => true,
            ],
        ];

        // Latest transactions heading
        $latestTransactionsHeading = [
            'main_heading' => 'Latest Transactions',
            'side_text' => 'View all',
        ];

        // Page content from database or defaults
        $pageContent = [
            'text_hello' => $page ? ($page->text_hello ?? 'Hello') : 'Hello',
            'title_main_balance' => $page ? ($page->title_main_balance ?? 'Main balance') : 'Main balance',
            'label_withdraw' => $page ? ($page->label_withdraw ?? 'Withdraw') : 'Withdraw',
            'label_transfer' => $page ? ($page->label_transfer ?? 'Transfer') : 'Transfer',
            'title_latest_transactions' => $page ? ($page->title_latest_transactions ?? 'Latest Transactions') : 'Latest Transactions',
            'button_view_all' => $page ? ($page->button_view_all ?? 'View All') : 'View All',
        ];

        // Update latest transactions heading if available in page content
        if ($page && isset($page->title_latest_transactions) && !empty($page->title_latest_transactions)) {
            $latestTransactionsHeading['main_heading'] = $page->title_latest_transactions;
        }
        if ($page && isset($page->button_view_all) && !empty($page->button_view_all)) {
            $latestTransactionsHeading['side_text'] = $page->button_view_all;
        }

        return response()->json([
            'wallet' => $wallet,
            'latest_transactions' => [
                'heading' => $latestTransactionsHeading,
                'transactions' => $transactions,
            ],
            'page_content' => $pageContent,
        ]);
    }
}