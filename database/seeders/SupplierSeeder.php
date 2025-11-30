<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
   public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Square Pharmaceuticals Ltd.',
                'contact_person' => 'Mr. Rahman',
                'email' => 'supply@square.com',
                'phone' => '+8801234567001',
                'address' => 'Square Centre, Dhaka, Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Beximco Pharmaceuticals Ltd.',
                'contact_person' => 'Ms. Akhter',
                'email' => 'supply@beximco.com',
                'phone' => '+8801234567002',
                'address' => 'Beximco Complex, Dhaka, Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'Incepta Pharmaceuticals Ltd.',
                'contact_person' => 'Mr. Hossain',
                'email' => 'supply@incepta.com',
                'phone' => '+8801234567003',
                'address' => 'Incepta House, Dhaka, Bangladesh',
                'is_active' => true,
            ],
            [
                'name' => 'ACI Limited',
                'contact_person' => 'Ms. Chowdhury',
                'email' => 'supply@aci.com',
                'phone' => '+8801234567004',
                'address' => 'ACI Centre, Dhaka, Bangladesh',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
