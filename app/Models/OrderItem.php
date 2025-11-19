<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'item_name',
        'quantity',
        'price_at_purchase',
        'selected_add_ons',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'selected_add_ons' => 'array',
    ];

    /**
     * Get the item details.
     */
    public function item()
    {
        // Use withDefault() in case the original item was deleted
        return $this->belongsTo(Item::class)->withDefault([
            'name' => $this->item_name ?? 'Deleted Item'
        ]);
    }
}