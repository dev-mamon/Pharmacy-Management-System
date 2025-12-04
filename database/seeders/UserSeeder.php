<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
     public function run(): void
    {


        User::create([
            'name' => 'Admin',
            'email' => 'admin@pharmacare.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Branch Manager',
            'email' => 'manager@pharmacare.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Pharmacist',
            'email' => 'pharmacist@pharmacare.com',
            'password' => Hash::make('password'),
            'role' => 'pharmacist',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Cashier',
            'email' => 'cashier1@pharmacare.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'is_active' => true,
        ]);
        User::create([
            'name' => 'Cashier',
            'email' => 'cashier2@pharmacare.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'is_active' => true,
        ]);
        User::create([
            'name' => 'Cashier',
            'email' => 'cashier41@pharmacare.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'is_active' => true,
        ]);
        User::create([
            'name' => 'Cashier',
            'email' => 'cashier52@pharmacare.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'is_active' => true,
        ]);

    }
}
