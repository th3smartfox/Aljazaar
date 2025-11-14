<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawerPage extends Model
{
    use HasFactory;

    protected $table = 'drawer_pages';

    protected $fillable = [
        'title',
        'button_my_account',
        'button_account_tier',
        'button_wallet',
        'button_change_information',
        'button_order_reordering',
        'button_order_tracking',
        'button_active_orders',
        'button_closed_orders',
        'button_redeem_rewards',
        'button_messages',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'button_my_account' => 'array',
        'button_account_tier' => 'array',
        'button_wallet' => 'array',
        'button_change_information' => 'array',
        'button_order_reordering' => 'array',
        'button_order_tracking' => 'array',
        'button_active_orders' => 'array',
        'button_closed_orders' => 'array',
        'button_redeem_rewards' => 'array',
        'button_messages' => 'array',
    ];
}