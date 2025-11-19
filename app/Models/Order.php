<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'sub_total',
        'discount_amount',
        'delivery_fee',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'delivery_notes',
    ];

    /**
     * Get the user that placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the delivery address for the order.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get all items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}