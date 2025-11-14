<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_page_contents', function (Blueprint $table) {
            // Carousels - array of carousel objects
            $table->json('carousels')->nullable()->after('status');
            
            // Tabs - array of tab objects (max 3)
            $table->json('tabs')->nullable()->after('carousels');
            
            // Headings for different sections
            $table->json('hot_discount_heading')->nullable()->after('tabs');
            $table->json('top_picks_heading')->nullable()->after('hot_discount_heading');
            $table->json('order_again_heading')->nullable()->after('top_picks_heading');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'carousels',
                'tabs',
                'hot_discount_heading',
                'top_picks_heading',
                'order_again_heading',
            ]);
        });
    }
};
