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
        // Step 1: Convert existing string data to JSON format
        $drawerPages = \DB::table('drawer_pages')->get();
        
        $iconDefaults = [
            'button_my_account' => 'FontAwesomeIcons.solidUser',
            'button_account_tier' => 'FontAwesomeIcons.userShield',
            'button_wallet' => 'FontAwesomeIcons.wallet',
            'button_change_information' => 'FontAwesomeIcons.penToSquare',
            'button_order_reordering' => 'FontAwesomeIcons.cartShopping',
            'button_order_tracking' => 'FontAwesomeIcons.truck',
            'button_active_orders' => 'FontAwesomeIcons.clock',
            'button_closed_orders' => 'FontAwesomeIcons.circleCheck',
            'button_redeem_rewards' => 'FontAwesomeIcons.gift',
            'button_messages' => 'FontAwesomeIcons.solidMessage',
        ];
        
        $subtitleDefaults = [
            'button_my_account' => false,
            'button_account_tier' => true,
            'button_wallet' => true,
            'button_change_information' => true,
            'button_order_reordering' => false,
            'button_order_tracking' => false,
            'button_active_orders' => false,
            'button_closed_orders' => false,
            'button_redeem_rewards' => false,
            'button_messages' => false,
        ];
        
        foreach ($drawerPages as $page) {
            $updates = [];
            
            foreach ($iconDefaults as $column => $defaultIcon) {
                $currentValue = $page->$column;
                
                // Convert string to JSON format
                $jsonValue = json_encode([
                    'title' => $currentValue ?? ucwords(str_replace('_', ' ', str_replace('button_', '', $column))),
                    'is_subtitle' => $subtitleDefaults[$column],
                    'icon' => $defaultIcon
                ]);
                
                $updates[$column] = $jsonValue;
            }
            
            \DB::table('drawer_pages')->where('id', $page->id)->update($updates);
        }
        
        // Step 2: Change column types to JSON
        Schema::table('drawer_pages', function (Blueprint $table) {
            $table->json('button_my_account')->nullable()->change();
            $table->json('button_account_tier')->nullable()->change();
            $table->json('button_wallet')->nullable()->change();
            $table->json('button_change_information')->nullable()->change();
            $table->json('button_order_reordering')->nullable()->change();
            $table->json('button_order_tracking')->nullable()->change();
            $table->json('button_active_orders')->nullable()->change();
            $table->json('button_closed_orders')->nullable()->change();
            $table->json('button_redeem_rewards')->nullable()->change();
            $table->json('button_messages')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drawer_pages', function (Blueprint $table) {
            // Revert back to string
            $table->string('button_my_account')->nullable()->change();
            $table->string('button_account_tier')->nullable()->change();
            $table->string('button_wallet')->nullable()->change();
            $table->string('button_change_information')->nullable()->change();
            $table->string('button_order_reordering')->nullable()->change();
            $table->string('button_order_tracking')->nullable()->change();
            $table->string('button_active_orders')->nullable()->change();
            $table->string('button_closed_orders')->nullable()->change();
            $table->string('button_redeem_rewards')->nullable()->change();
            $table->string('button_messages')->nullable()->change();
        });
    }
};
