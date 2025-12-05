<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Branch;
use App\Models\User;

class StockTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::pluck('id')->toArray();

        // If no branches exist, stop seeding to avoid errors
        if (count($branches) < 2) {
            dd("❌ Need at least 2 branches to create stock transfers.");
        }

        $userId = User::first()->id ?? 1; // first user or fallback

        for ($i = 1; $i <= 15; $i++) {

            // pick two DIFFERENT branches
            $from = $branches[array_rand($branches)];
            do {
                $to = $branches[array_rand($branches)];
            } while ($to == $from);

            DB::table('stock_transfers')->insert([
                'transfer_number' => 'TR-' . strtoupper(Str::random(6)),
                'from_branch_id'  => $from,
                'to_branch_id'    => $to,
                'user_id'         => $userId,
                'transfer_date'   => now()->subDays(rand(1, 30)),
                'status'          => ['pending', 'approved', 'rejected', 'completed'][rand(0, 3)],
                'notes'           => 'Auto generated stock transfer #' . $i,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
