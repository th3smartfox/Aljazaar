<?php

namespace App\Http\Resources\Items;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ItemResource extends JsonResource
{
    protected $pageContent;

    public function __construct($resource, $pageContent = null)
    {
        parent::__construct($resource);
        $this->pageContent = $pageContent;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image ? Storage::url($this->image) : null,
            'base_price' => (float) $this->base_price,
            'discount_percent' => (float) $this->discount_percent,
            'discounted_price' => (float) $this->discounted_price,
            'status' => $this->status,
            'customization_options' => $this->addOns, // Legacy support if needed, or just use addOns
            'category' => $this->whenLoaded('category'),
            'created_at' => $this->created_at->toDateTimeString(),
            'add_ons' => $this->addOns->map(function ($addOn) {
                return [
                    'id' => $addOn->id,
                    'name' => $addOn->name,
                    'price' => (float) $addOn->price,
                ];
            }),
            'is_wishlisted' => $request->user('sanctum') ? $this->wishlists()->where('user_id', $request->user('sanctum')->id)->exists() : false,
        ];

        // Add page content if provided
        if ($this->pageContent) {
            $data['page_content'] = $this->pageContent;
        }

        return $data;
    }
}