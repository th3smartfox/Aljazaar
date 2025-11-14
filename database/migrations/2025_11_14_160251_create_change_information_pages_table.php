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
        Schema::create('change_information_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            
            // Account Section
            $table->string('label_account')->nullable();
            $table->string('label_personal_information')->nullable();

            // Payment Section
            $table->string('label_payment_method')->nullable();
            $table->string('label_card_information')->nullable();
            
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_information_pages');
    }
};
