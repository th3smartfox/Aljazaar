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
        Schema::create('add_ons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('cart_item_add_ons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // 'carts' table acts as cart_items
            $table->foreignId('add_on_id')->constrained('add_ons')->onDelete('cascade');
            $table->string('add_on_name');
            $table->decimal('add_on_price', 10, 2);
            $table->timestamps();
        });

        // Migrate existing customization_options to add_ons table
        $items = \Illuminate\Support\Facades\DB::table('items')->get();
        foreach ($items as $item) {
            if (!empty($item->customization_options)) {
                $options = json_decode($item->customization_options, true);
                if (is_array($options)) {
                    foreach ($options as $option) {
                        if (isset($option['name']) && isset($option['price'])) {
                            \Illuminate\Support\Facades\DB::table('add_ons')->insert([
                                'item_id' => $item->id,
                                'name' => $option['name'],
                                'price' => $option['price'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item_add_ons');
        Schema::dropIfExists('add_ons');
    }
};
