<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'customer_id' => 'CUST001',
                'name' => 'Abdul Rahman',
                'phone' => '+8801712345678',
                'email' => 'abdul@example.com',
                'address' => '123 Mirpur, Dhaka',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
                'loyalty_points' => 150,
                'total_spent' => 5000,
                'blood_group' => 'B+',
                'allergies' => 'Penicillin',
                'medical_history' => 'Hypertension',
                'is_active' => true,
            ],
            [
                'customer_id' => 'CUST002',
                'name' => 'Fatima Begum',
                'phone' => '+8801812345678',
                'email' => 'fatima@example.com',
                'address' => '456 Dhanmondi, Dhaka',
                'date_of_birth' => '1990-08-20',
                'gender' => 'female',
                'loyalty_points' => 75,
                'total_spent' => 2500,
                'blood_group' => 'O+',
                'allergies' => 'None',
                'medical_history' => 'Diabetes',
                'is_active' => true,
            ],
            [
                'customer_id' => 'CUST003',
                'name' => 'Mohammad Ali',
                'phone' => '+8801912345678',
                'email' => 'ali@example.com',
                'address' => '789 Uttara, Dhaka',
                'date_of_birth' => '1978-12-10',
                'gender' => 'male',
                'loyalty_points' => 300,
                'total_spent' => 12000,
                'blood_group' => 'A+',
                'allergies' => 'Sulfa drugs',
                'medical_history' => 'Asthma',
                'is_active' => true,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
