<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\Branch;
use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockSeeder extends Seeder
{
public function run(): void
    {
        $medicines = Medicine::all();
        $branches = Branch::all();

        foreach ($branches as $branch) {
            foreach ($medicines as $medicine) {
                Stock::create([
                    'medicine_id' => $medicine->id,
                    'branch_id' => $branch->id,
                    'batch_number' => 'BATCH' . rand(1000, 9999),
                    'expiry_date' => now()->addYears(2),
                    'purchase_price' => rand(50, 500),
                    'selling_price' => rand(60, 600),
                    'quantity' => rand(100, 1000),
                    'min_stock_level' => 50,
                    'reorder_level' => 100,
                ]);
            }
        }
    }
}
