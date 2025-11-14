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
        Schema::create('wallet_pages', function (Blueprint $table) {
            $table->id();
            $table->string('text_hello')->nullable();
            $table->string('title_main_balance')->nullable();
            $table->string('label_withdraw')->nullable();
            $table->string('label_transfer')->nullable();
            $table->string('title_latest_transactions')->nullable();
            $table->string('button_view_all')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_pages');
    }
};
