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
        Schema::create('select_city_page_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('select_city_page_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('city_id');
            $table->string('image_path');
            $table->timestamps();

            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('select_city_page_cities');
    }
};


