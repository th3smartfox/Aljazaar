<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageContent extends Model
{
    use HasFactory;

    protected $table = 'home_page_contents';

    protected $fillable = [
        'tab_new_order',
        'tab_newest',
        'tab_most_favorite',
        'title_hot_discounts',
        'text_see_all',
        'hot_discounts_see_all',
        'top_picks_see_all',
        'order_again_see_all',
        'title_top_picks',
        'title_for_you',
        'title_order_again',
        'status',
        'carousels',
        'tabs',
        'hot_discount_heading',
        'top_picks_heading',
        'order_again_heading',
    ];

    protected $casts = [
        'status' => 'boolean',
        'carousels' => 'array',
        'tabs' => 'array',
        'hot_discount_heading' => 'array',
        'top_picks_heading' => 'array',
        'order_again_heading' => 'array',
    ];
}