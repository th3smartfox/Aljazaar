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
        Schema::table('signup_pages', function (Blueprint $table) {
            $table->string('full_name_hint')->nullable()->after('full_name_label');
            $table->string('phone_number_hint')->nullable()->after('phone_number_label');
            $table->string('password_hint')->nullable()->after('password_label');
            $table->dropColumn('email_address_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signup_pages', function (Blueprint $table) {
            $table->dropColumn(['full_name_hint', 'phone_number_hint', 'password_hint']);
            $table->string('email_address_label')->nullable();
        });
    }
};
