<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        // total medicines, suppliers, branches, users must exist
        $medicineCount = DB::table('medicines')->count();
        $supplierCount = DB::table('suppliers')->count();
        $branchCount   = DB::table('branches')->count();
        $userCount     = DB::table('users')->count();

        for ($i = 1; $i <= 100; $i++) {

            // --------- PURCHASE INSERT -------------
            $purchaseNumber = 'PUR-' . str_pad($i, 5, '0', STR_PAD_LEFT);

            $purchaseId = DB::table('purchases')->insertGetId([
                'purchase_number' => $purchaseNumber,
                'supplier_id'     => rand(1, $supplierCount),
                'branch_id'       => rand(1, $branchCount),
                'user_id'         => rand(1, $userCount),
                'purchase_date'   => Carbon::now()->subDays(rand(1, 365)),
                'total_amount'    => 0,
                'discount'        => rand(0, 100),
                'tax_amount'      => rand(0, 200),
                'grand_total'     => 0,
                'status'          => 'completed',
                'notes'           => 'Auto generated purchase record',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // --------- ADD ITEMS -------------
            $itemCount = rand(2, 5); // each purchase has 2–5 items
            $totalAmount = 0;

            for ($j = 1; $j <= $itemCount; $j++) {

                $purchasePrice = rand(5, 50);
                $sellingPrice = $purchasePrice + rand(5, 20);
                $qty = rand(1, 20);
                $amount = $purchasePrice * $qty;

                DB::table('purchase_items')->insert([
                    'purchase_id'  => $purchaseId,
                    'medicine_id'  => rand(1, $medicineCount),
                    'batch_number' => strtoupper(Str::random(8)),
                    'expiry_date'  => Carbon::now()->addMonths(rand(6, 36)),
                    'quantity'     => $qty,
                    'purchase_price' => $purchasePrice,
                    'selling_price'  => $sellingPrice,
                    'total_amount'   => $amount,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                $totalAmount += $amount;
            }

            // --------- UPDATE TOTALS -------------
            $grandTotal = $totalAmount - rand(0, 100) + rand(0, 200);

            DB::table('purchases')
                ->where('id', $purchaseId)
                ->update([
                    'total_amount' => $totalAmount,
                    'grand_total'  => max($grandTotal, 0),
                ]);
        }
    }
}
