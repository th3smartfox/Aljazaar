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
        Schema::create('redeem_rewards_pages', function (Blueprint $table) {
            $table->id();
            $table->string('app_bar_title')->default('Redeem Rewards');
            $table->string('empty_title')->default('No Rewards Available');
            $table->string('empty_subtitle')->default('Check back later for exciting rewards!');
            $table->string('copy_button_text')->default('Copy Code');
            $table->string('copied_message')->default('Code copied to clipboard!');
            $table->string('min_order_label')->default('Min Order');
            $table->string('max_discount_label')->default('Max Discount');
            $table->string('expired_label')->default('Expired');
            $table->string('redeemed_label')->default('Redeemed');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_rewards_pages');
    }
};
