<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomePageContent;
use App\Models\Item;
use App\Models\DrawerPage;
use App\Http\Resources\Content\HomePageContentResource;
use App\Http\Resources\Content\DrawerPageResource;
use App\Http\Resources\Items\ItemSummaryResource;
use Illuminate\Http\Request;

class HomePageContentController extends Controller
{
    /**
     * Mobile app ko active home page ka content dega.
     * Hamesha sab se naya (latest) active item uthayega.
     */
    public function getPageContent()
    {
        $page = HomePageContent::where('status', true)->latest()->first();

        // Get drawer page content (needed for both cases)
        $drawerPage = DrawerPage::where('status', true)->latest()->first();
        $drawerPageData = null;

        if ($drawerPage) {
            $drawerPageData = new DrawerPageResource($drawerPage);
        } else {
            // Default drawer page structure
            $drawerPageData = [
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
            ];
        }

        // Resolve drawer page data to array if it's a Resource
        $drawerItems = null;
        if ($drawerPageData instanceof \Illuminate\Http\Resources\Json\JsonResource) {
            $drawerItems = $drawerPageData->resolve();
        } else {
            $drawerItems = $drawerPageData;
        }

        if (!$page) {
            // Return default structure if no page found
            return response()->json([
                'carousels' => [],
                'tabs' => [],
                'hot_discount_heading' => [
                    'main_heading' => 'Hot discounts',
                    'sub_heading' => '',
                ],
                'hot_discounts' => [],
                'top_picks_heading' => [
                    'main_heading' => 'Top picks',
                    'sub_heading' => '',
                ],
                'top_picks' => [],
                'order_again_heading' => [
                    'main_heading' => 'Order Again',
                    'sub_heading' => '',
                ],
                'order_again' => [],
                'page_content' => [
                    'drawer_items' => [],
                ],
            ]);
        }

        // Get hot discounts items (from ItemController hotDiscounts method logic)
        $hotDiscounts = Item::with('category:id,name')
            ->where('status', true)
            ->orderBy('discount_percent', 'DESC')
            ->limit(10)
            ->get();

        // Get top picks items (desc order by created_at)
        $topPicks = Item::with('category:id,name')
            ->where('status', true)
            ->latest()
            ->limit(10)
            ->get();

        // Get order again items (desc order by created_at - for now, later will be user orders)
        $orderAgain = Item::with('category:id,name')
            ->where('status', true)
            ->latest()
            ->limit(10)
            ->get();

        return new HomePageContentResource($page, $hotDiscounts, $topPicks, $orderAgain, $drawerPageData);
    }
}