<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletPage extends Model
{
    use HasFactory;

    protected $table = 'wallet_pages';

    protected $fillable = [
        'text_hello',
        'title_main_balance',
        'label_withdraw',
        'label_transfer',
        'title_latest_transactions',
        'button_view_all',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}