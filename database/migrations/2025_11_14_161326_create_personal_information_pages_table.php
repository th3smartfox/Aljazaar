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
        Schema::create('personal_information_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('label_name')->nullable();
            $table->string('label_email')->nullable();
            $table->string('label_phone')->nullable();
            $table->string('button_cancel')->nullable();
            $table->string('button_save')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information_pages');
    }
};
