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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('cascade');
            $table->enum('status', ['trial', 'active', 'cancelled', 'expired'])->default('trial');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('trial_end_date')->nullable();
            $table->boolean('auto_renew')->default(true);
            $table->dateTime('cancelled_at')->nullable();
            $table->timestamps();

            // Only one active subscription per user
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
