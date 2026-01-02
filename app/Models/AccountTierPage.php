<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTierPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_bar_title',
        'header_image',
        'subtitle',
        'button_text',
        'terms_text',
        'terms_of_service_text',
        'privacy_policy_text',
        'renewal_notice',
    ];
}
