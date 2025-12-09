<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            BranchSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            MedicineSeeder::class,
            StockSeeder::class,
            CustomerSeeder::class,
            TaxSettingSeeder::class,
            PaymentMethodSeeder::class,
            LoyaltyProgramSeeder::class,
            ExpiryAlertsSeeder::class,
            PurchaseSeeder::class,
            StockTransferSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
