<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemAddOn extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'add_on_id',
        'add_on_name',
        'add_on_price',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
