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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // 'cod', 'credit_card', 'paypal', etc.
            $table->string('status'); // 'pending', 'completed', 'failed'
            $table->string('transaction_id')->nullable(); // Payment gateway ID
            $table->text('gateway_response')->nullable(); // Gateway response (JSON)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
