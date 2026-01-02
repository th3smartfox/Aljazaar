<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemRewardsPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_bar_title',
        'empty_title',
        'empty_subtitle',
        'copy_button_text',
        'copied_message',
        'min_order_label',
        'max_discount_label',
        'expired_label',
        'redeemed_label',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
