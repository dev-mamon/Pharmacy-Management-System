<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Main Branch',
            'code' => 'MB001',
            'address' => '123 Main Street, City Center',
            'phone' => '+8801234567890',
            'email' => 'main@pharmacare.com',
            'manager_name' => 'John Doe',
            'opening_time' => '08:00:00',
            'closing_time' => '22:00:00',
            'is_active' => true,
        ]);

        Branch::create([
            'name' => 'North Branch',
            'code' => 'NB002',
            'address' => '456 North Avenue, North City',
            'phone' => '+8801234567891',
            'email' => 'north@pharmacare.com',
            'manager_name' => 'Jane Smith',
            'opening_time' => '09:00:00',
            'closing_time' => '21:00:00',
            'is_active' => true,
        ]);

        Branch::create([
            'name' => 'South Branch',
            'code' => 'SB003',
            'address' => '789 South Road, South City',
            'phone' => '+8801234567892',
            'email' => 'south@pharmacare.com',
            'manager_name' => 'Mike Johnson',
            'opening_time' => '08:30:00',
            'closing_time' => '22:30:00',
            'is_active' => true,
        ]);
    }
}
