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
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable()->after('user_id');
            $table->string('nearest_landmark')->nullable()->after('street_number');
            $table->renameColumn('landmarks', 'landmark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('city_id');
            $table->dropColumn('nearest_landmark');
            $table->renameColumn('landmark', 'landmarks');
        });
    }
};
