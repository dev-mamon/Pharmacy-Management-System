<?php

namespace Database\Seeders;

use App\Models\TaxSetting;
use Illuminate\Database\Seeder;

class TaxSettingSeeder extends Seeder
{
    public function run(): void
    {
        TaxSetting::create([
            'tax_name' => 'VAT',
            'tax_rate' => 15.00,
            'tax_type' => 'percentage',
            'is_active' => true,
            'effective_from' => now(),
            'effective_to' => null,
        ]);

        TaxSetting::create([
            'tax_name' => 'Service Tax',
            'tax_rate' => 5.00,
            'tax_type' => 'percentage',
            'is_active' => true,
            'effective_from' => now(),
            'effective_to' => null,
        ]);
    }
}
