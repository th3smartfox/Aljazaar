<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('signin_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('sub_title');
            $table->string('email_or_phone_label');
            $table->string('email_or_phone_hint');
            $table->string('password_label');
            $table->string('password_hint');
            $table->string('forgot_password_text');
            $table->string('login_button_text');
            $table->string('dont_have_account_text');
            $table->string('sign_up_text');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signin_pages');
    }
};
