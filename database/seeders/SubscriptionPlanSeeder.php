<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Silver Membership',
                'description' => '$5 OFF on every order',
                'price' => 9.99,
                'discount_per_order' => '$5',
                'duration_days' => 30,
                'trial_days' => 7,
                'badge' => null,
                'is_recommended' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Premium Membership',
                'description' => '$10 OFF on every order',
                'price' => 19.99,
                'discount_per_order' => '$10',
                'duration_days' => 30,
                'trial_days' => 7,
                'badge' => 'Best Value',
                'is_recommended' => true,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::firstOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}
