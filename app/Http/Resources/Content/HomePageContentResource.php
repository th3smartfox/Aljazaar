<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HomePageContentResource extends JsonResource
{
    protected $hotDiscounts;
    protected $topPicks;
    protected $orderAgain;
    protected $drawerPageData;

    public function __construct($resource, $hotDiscounts = null, $topPicks = null, $orderAgain = null, $drawerPageData = null)
    {
        parent::__construct($resource);
        $this->hotDiscounts = $hotDiscounts;
        $this->topPicks = $topPicks;
        $this->orderAgain = $orderAgain;
        $this->drawerPageData = $drawerPageData;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Format carousels
        $carousels = [];
        if ($this->carousels && is_array($this->carousels)) {
            foreach ($this->carousels as $carousel) {
                $carousels[] = [
                    'heading' => $carousel['heading'] ?? '',
                    'body' => $carousel['body'] ?? '',
                    'button_text' => $carousel['button_text'] ?? '',
                    'image' => isset($carousel['image']) ? Storage::url($carousel['image']) : '',
                ];
            }
        }

        // Format tabs (limit to 3)
        $tabs = [];
        if ($this->tabs && is_array($this->tabs)) {
            $tabs = array_slice($this->tabs, 0, 3);
            foreach ($tabs as &$tab) {
                $tab['image'] = isset($tab['image']) ? Storage::url($tab['image']) : '';
            }
        }

        // Format headings
        $hotDiscountHeading = $this->hot_discount_heading ?? [
            'main_heading' => $this->title_hot_discounts ?? 'Hot discounts',
            'sub_heading' => '',
            'side_text' => 'See All',
        ];
        if (!isset($hotDiscountHeading['side_text'])) {
            $hotDiscountHeading['side_text'] = 'See All';
        }

        $topPicksHeading = $this->top_picks_heading ?? [
            'main_heading' => $this->title_top_picks ?? 'Top picks',
            'sub_heading' => '',
            'side_text' => 'See All',
        ];
        if (!isset($topPicksHeading['side_text'])) {
            $topPicksHeading['side_text'] = 'See All';
        }

        $orderAgainHeading = $this->order_again_heading ?? [
            'main_heading' => $this->title_order_again ?? 'Order Again',
            'sub_heading' => '',
            'side_text' => 'See All',
        ];
        if (!isset($orderAgainHeading['side_text'])) {
            $orderAgainHeading['side_text'] = 'See All';
        }

        // Format hot discounts items
        $hotDiscountsFormatted = [];
        if ($this->hotDiscounts) {
            foreach ($this->hotDiscounts as $item) {
                $hotDiscountsFormatted[] = [
                    'id' => $item->id,
                    'title' => $item->name,
                    'sub_title' => $item->description ?? ($item->category->name ?? ''),
                    'ratings' => '4.5', // Default value, will be updated when ratings are added
                    'average_delivery_time' => '30 min', // Default value
                    'free_delivery' => true, // Default value
                    'image' => $item->image ? Storage::url($item->image) : null,
                ];
            }
        }

        // Format top picks items
        $topPicksFormatted = [];
        if ($this->topPicks) {
            foreach ($this->topPicks as $item) {
                $topPicksFormatted[] = [
                    'id' => $item->id,
                    'title' => $item->name,
                    'sub_title' => $item->description ?? ($item->category->name ?? ''),
                    'price' => (string) $item->discounted_price,
                    'image' => $item->image ? Storage::url($item->image) : null,
                ];
            }
        }

        // Format order again items
        $orderAgainFormatted = [];
        if ($this->orderAgain) {
            foreach ($this->orderAgain as $item) {
                $orderAgainFormatted[] = [
                    'id' => $item->id,
                    'title' => $item->name,
                    'ratings' => '4.5', // Default value
                    'average_delivery_time' => '30 min', // Default value
                    'price' => (string) $item->discounted_price,
                    'image' => $item->image ? Storage::url($item->image) : null,
                ];
            }
        }

        // Format drawer page data
        $drawerItems = null;
        if ($this->drawerPageData) {
            // If it's a Resource object, resolve it to array
            if ($this->drawerPageData instanceof \Illuminate\Http\Resources\Json\JsonResource) {
                $drawerItems = $this->drawerPageData->resolve();
            } else {
                // If it's already an array
                $drawerItems = $this->drawerPageData;
            }
        }

        return [
            'carousels' => $carousels,
            'tabs' => $tabs,
            'hot_discount_heading' => $hotDiscountHeading,
            'hot_discounts' => $hotDiscountsFormatted,
            'top_picks_heading' => $topPicksHeading,
            'top_picks' => $topPicksFormatted,
            'order_again_heading' => $orderAgainHeading,
            'order_again' => $orderAgainFormatted,
            'page_content' => [
                'drawer_items' => $drawerItems,
            ],
        ];
    }
}