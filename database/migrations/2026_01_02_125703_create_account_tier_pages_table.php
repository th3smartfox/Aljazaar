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
        Schema::create('account_tier_pages', function (Blueprint $table) {
            $table->id();
            $table->string('app_bar_title')->default('Get Subscription');
            $table->string('header_image')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('button_text')->default('Start 7-day free trial');
            $table->text('terms_text')->nullable();
            $table->string('terms_of_service_text')->default('Terms of Service');
            $table->string('privacy_policy_text')->default('Privacy Policy');
            $table->text('renewal_notice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_tier_pages');
    }
};
