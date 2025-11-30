<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpiryAlertsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alerts = [];

        // Get some stock IDs to associate with alerts
        $stockIds = DB::table('stocks')->pluck('id')->toArray();
        $branchIds = DB::table('branches')->pluck('id')->toArray();

        // If no stocks exist, create some sample data
        if (empty($stockIds)) {
            // Create sample stocks first
            DB::table('stocks')->insert([
                ['medicine_id' => 1, 'branch_id' => 1, 'batch_number' => 'BATCH001', 'expiry_date' => now()->addDays(5), 'purchase_price' => 10.50, 'selling_price' => 15.00, 'quantity' => 50, 'min_stock_level' => 10, 'reorder_level' => 20, 'created_at' => now(), 'updated_at' => now()],
                ['medicine_id' => 2, 'branch_id' => 1, 'batch_number' => 'BATCH002', 'expiry_date' => now()->addDays(15), 'purchase_price' => 8.75, 'selling_price' => 12.50, 'quantity' => 30, 'min_stock_level' => 10, 'reorder_level' => 20, 'created_at' => now(), 'updated_at' => now()],
                ['medicine_id' => 3, 'branch_id' => 1, 'batch_number' => 'BATCH003', 'expiry_date' => now()->addDays(45), 'purchase_price' => 25.00, 'selling_price' => 35.00, 'quantity' => 20, 'min_stock_level' => 5, 'reorder_level' => 10, 'created_at' => now(), 'updated_at' => now()],
                ['medicine_id' => 4, 'branch_id' => 2, 'batch_number' => 'BATCH004', 'expiry_date' => now()->addDays(3), 'purchase_price' => 5.25, 'selling_price' => 8.00, 'quantity' => 100, 'min_stock_level' => 20, 'reorder_level' => 40, 'created_at' => now(), 'updated_at' => now()],
                ['medicine_id' => 5, 'branch_id' => 2, 'batch_number' => 'BATCH005', 'expiry_date' => now()->addDays(60), 'purchase_price' => 15.75, 'selling_price' => 22.00, 'quantity' => 40, 'min_stock_level' => 10, 'reorder_level' => 20, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $stockIds = DB::table('stocks')->pluck('id')->toArray();
        }

        if (empty($branchIds)) {
            // Create sample branches
            DB::table('branches')->insert([
                ['name' => 'Main Branch', 'address' => '123 Main St', 'phone' => '+1234567890', 'email' => 'main@pharmacy.com', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Downtown Branch', 'address' => '456 Downtown Ave', 'phone' => '+1234567891', 'email' => 'downtown@pharmacy.com', 'created_at' => now(), 'updated_at' => now()],
            ]);

            $branchIds = DB::table('branches')->pluck('id')->toArray();
        }

        // Create critical alerts (expiring in 0-7 days)
        foreach (array_slice($stockIds, 0, 3) as $stockId) {
            $expiryDate = now()->addDays(rand(1, 7));
            $daysUntilExpiry = now()->diffInDays($expiryDate);

            $alerts[] = [
                'stock_id' => $stockId,
                'branch_id' => $branchIds[array_rand($branchIds)],
                'expiry_date' => $expiryDate,
                'days_until_expiry' => $daysUntilExpiry,
                'alert_level' => 'critical',
                'is_notified' => rand(0, 1),
                'notified_at' => rand(0, 1) ? now()->subDays(rand(1, 3)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Create warning alerts (expiring in 8-30 days)
        foreach (array_slice($stockIds, 3, 2) as $stockId) {
            $expiryDate = now()->addDays(rand(8, 30));
            $daysUntilExpiry = now()->diffInDays($expiryDate);

            $alerts[] = [
                'stock_id' => $stockId,
                'branch_id' => $branchIds[array_rand($branchIds)],
                'expiry_date' => $expiryDate,
                'days_until_expiry' => $daysUntilExpiry,
                'alert_level' => 'warning',
                'is_notified' => rand(0, 1),
                'notified_at' => rand(0, 1) ? now()->subDays(rand(1, 5)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Create info alerts (expiring in 31-90 days)
        foreach (array_slice($stockIds, 5, 2) as $stockId) {
            $expiryDate = now()->addDays(rand(31, 90));
            $daysUntilExpiry = now()->diffInDays($expiryDate);

            $alerts[] = [
                'stock_id' => $stockId,
                'branch_id' => $branchIds[array_rand($branchIds)],
                'expiry_date' => $expiryDate,
                'days_until_expiry' => $daysUntilExpiry,
                'alert_level' => 'info',
                'is_notified' => false,
                'notified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert the alerts
        DB::table('expiry_alerts')->insert($alerts);

        $this->command->info('Expiry alerts seeded successfully!');
        $this->command->info('Critical alerts: ' . count(array_filter($alerts, fn($alert) => $alert['alert_level'] === 'critical')));
        $this->command->info('Warning alerts: ' . count(array_filter($alerts, fn($alert) => $alert['alert_level'] === 'warning')));
        $this->command->info('Info alerts: ' . count(array_filter($alerts, fn($alert) => $alert['alert_level'] === 'info')));
    }
}
