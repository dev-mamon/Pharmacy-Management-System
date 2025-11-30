<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Cash',
                'code' => 'CASH',
                'is_active' => true,
                'processing_fee' => 0.00,
                'processor' => null,
                'config' => null,
            ],
            [
                'name' => 'Credit Card',
                'code' => 'CREDIT_CARD',
                'is_active' => true,
                'processing_fee' => 2.50,
                'processor' => 'Visa/Mastercard',
                'config' => ['merchant_id' => '12345'],
            ],
            [
                'name' => 'Mobile Banking',
                'code' => 'MOBILE_BANKING',
                'is_active' => true,
                'processing_fee' => 1.00,
                'processor' => 'bKash/Nagad',
                'config' => ['merchant_number' => '017XXXXXXXX'],
            ],
            [
                'name' => 'Bank Transfer',
                'code' => 'BANK_TRANSFER',
                'is_active' => true,
                'processing_fee' => 0.50,
                'processor' => 'Local Banks',
                'config' => ['account_number' => '1234567890'],
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
