<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;

class DrawerPageResource extends JsonResource
{
    public function toArray($request)
    {
        // Format buttons with default values if not set
        $formatButton = function ($button, $defaultTitle, $defaultIcon, $defaultIsSubtitle = false) {
            if (is_array($button) && !empty($button)) {
                return [
                    'title' => $button['title'] ?? $defaultTitle,
                    'is_subtitle' => isset($button['is_subtitle']) ? (bool) $button['is_subtitle'] : $defaultIsSubtitle,
                    'icon' => $button['icon'] ?? $defaultIcon,
                ];
            }
            return [
                'title' => $defaultTitle,
                'is_subtitle' => $defaultIsSubtitle,
                'icon' => $defaultIcon,
            ];
        };

        return [
            'title' => $this->title ?? 'Royal Butcher',
            'button_my_account' => $formatButton($this->button_my_account, 'My Account', 'FontAwesomeIcons.solidUser', false),
            'button_account_tier' => $formatButton($this->button_account_tier, 'Account Tier', 'FontAwesomeIcons.userShield', true),
            'button_wallet' => $formatButton($this->button_wallet, 'Wallet', 'FontAwesomeIcons.wallet', true),
            'button_change_information' => $formatButton($this->button_change_information, 'Change Information', 'FontAwesomeIcons.penToSquare', true),
            'button_order_reordering' => $formatButton($this->button_order_reordering, 'Order Tracking', 'FontAwesomeIcons.cartShopping', false),
            'button_redeem_rewards' => $formatButton($this->button_redeem_rewards, 'Redeem Rewards', 'FontAwesomeIcons.gift', false),
            'button_messages' => $formatButton($this->button_messages, 'Messages', 'FontAwesomeIcons.solidMessage', false),
        ];
    }
}