<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = Medicine::all();
        $stocks = Stock::all();
        $branches = Branch::all();
        $users = User::all();

        if ($medicines->isEmpty() || $stocks->isEmpty() || $branches->isEmpty() || $users->isEmpty()) {
            dd('Make sure medicines, stocks, branches, and users tables have data first!');
        }

        for ($i = 1; $i <= 20; $i++) {

            $subTotal = 0;

            $sale = Sale::create([
                'invoice_number' => 'INV-'.strtoupper(Str::random(6)),
                'branch_id' => $branches->random()->id,
                'user_id' => $users->random()->id,
                'sale_date' => now()->subDays(rand(0, 30)),
                'sub_total' => 0,
                'discount' => rand(0, 50),
                'tax_amount' => rand(1, 20),
                'grand_total' => 0,
                'payment_method' => ['cash', 'card', 'mobile_banking', 'other'][rand(0, 3)],
                'status' => 'completed',
                'customer_name' => fake()->name(),
                'customer_phone' => fake()->phoneNumber(),
                'notes' => fake()->sentence(),
            ]);

            // Add 1–5 sale items to each sale
            $itemCount = rand(1, 5);

            for ($j = 0; $j < $itemCount; $j++) {

                $medicine = $medicines->random();
                $stock = $stocks->where('medicine_id', $medicine->id)->random() ?? $stocks->random();

                $quantity = rand(1, 5);
                $unitPrice = rand(50, 500);
                $total = $quantity * $unitPrice;

                $subTotal += $total;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $medicine->id,
                    'stock_id' => $stock->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_amount' => $total,
                ]);
            }

            // update totals
            $sale->update([
                'sub_total' => $subTotal,
                'grand_total' => $subTotal - $sale->discount + $sale->tax_amount,
            ]);
        }
    }
}
