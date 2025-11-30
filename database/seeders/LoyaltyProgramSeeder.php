<?php

namespace Database\Seeders;

use App\Models\LoyaltyProgram;
use Illuminate\Database\Seeder;

class LoyaltyProgramSeeder extends Seeder
{
    public function run(): void
    {
        LoyaltyProgram::create([
            'name' => 'Standard Loyalty Program',
            'points_per_purchase' => 10,
            'points_per_amount' => 1,
            'minimum_redemption_points' => 100,
            'point_value' => 0.10,
            'is_active' => true,
            'valid_from' => now(),
            'valid_to' => now()->addYears(1),
        ]);

        LoyaltyProgram::create([
            'name' => 'Premium Loyalty Program',
            'points_per_purchase' => 20,
            'points_per_amount' => 2,
            'minimum_redemption_points' => 50,
            'point_value' => 0.20,
            'is_active' => true,
            'valid_from' => now(),
            'valid_to' => now()->addYears(1),
        ]);
    }
}
