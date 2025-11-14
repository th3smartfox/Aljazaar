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
        Schema::create('drawer_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('button_my_account')->nullable();
            $table->string('button_account_tier')->nullable();
            $table->string('button_wallet')->nullable();
            $table->string('button_change_information')->nullable();
            $table->string('button_order_reordering')->nullable();
            $table->string('button_order_tracking')->nullable();
            $table->string('button_active_orders')->nullable();
            $table->string('button_closed_orders')->nullable();
            $table->string('button_redeem_rewards')->nullable();
            $table->string('button_messages')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drawer_pages');
    }
};
