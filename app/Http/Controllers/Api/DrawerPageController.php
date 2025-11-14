<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DrawerPage;
use App\Http\Resources\Content\DrawerPageResource;
use Illuminate\Http\Request;

class DrawerPageController extends Controller
{
    public function getPageContent()
    {
        $page = DrawerPage::where('status', true)->latest()->first();

        if (!$page) {
            // Return default structure with new format
            return response()->json([
                'title' => 'Royal Butcher',
                'button_my_account' => [
                    'title' => 'My Account',
                    'is_subtitle' => false,
                    'icon' => 'FontAwesomeIcons.solidUser'
                ],
                'button_account_tier' => [
                    'title' => 'Account Tier',
                    'is_subtitle' => true,
                    'icon' => 'FontAwesomeIcons.userShield'
                ],
                'button_wallet' => [
                    'title' => 'Wallet',
                    'is_subtitle' => true,
                    'icon' => 'FontAwesomeIcons.wallet'
                ],
                'button_change_information' => [
                    'title' => 'Change Information',
                    'is_subtitle' => true,
                    'icon' => 'FontAwesomeIcons.penToSquare'
                ],
                'button_order_reordering' => [
                    'title' => 'Order Tracking',
                    'is_subtitle' => false,
                    'icon' => 'FontAwesomeIcons.cartShopping'
                ],
                'button_redeem_rewards' => [
                    'title' => 'Redeem Rewards',
                    'is_subtitle' => false,
                    'icon' => 'FontAwesomeIcons.gift'
                ],
                'button_messages' => [
                    'title' => 'Messages',
                    'is_subtitle' => false,
                    'icon' => 'FontAwesomeIcons.solidMessage'
                ],
            ]);
        }

        return new DrawerPageResource($page);
    }
}