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
            // Add separate see_all fields for each section
            $table->string('hot_discounts_see_all')->nullable()->after('text_see_all')->default('See all');
            $table->string('top_picks_see_all')->nullable()->after('hot_discounts_see_all')->default('See all');
            $table->string('order_again_see_all')->nullable()->after('top_picks_see_all')->default('See all');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'hot_discounts_see_all',
                'top_picks_see_all',
                'order_again_see_all',
            ]);
        });
    }
};
