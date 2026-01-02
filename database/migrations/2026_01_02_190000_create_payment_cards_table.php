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
        Schema::create('payment_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_holder_name', 100);
            $table->string('last_four_digits', 4);
            $table->enum('brand', ['visa', 'mastercard', 'amex', 'discover', 'dinersclub', 'jcb', 'unionpay']);
            $table->string('expiry_month', 2);
            $table->string('expiry_year', 2);
            $table->boolean('is_default')->default(false);
            $table->string('stripe_payment_method_id')->nullable();
            $table->string('fingerprint')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
            $table->unique(['user_id', 'fingerprint']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_cards');
    }
};
