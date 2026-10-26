<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Customer::insert([
            [
                'full_name' => 'Ana Cruz',
                'email' => 'ana@example.com',
                'phone' => '09171234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Ben Santos',
                'email' => 'ben@example.com',
                'phone' => '09181234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Carla Reyes',
                'email' => 'carla@example.com',
                'phone' => '09191234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Daniel Garcia',
                'email' => 'daniel@example.com',
                'phone' => '09201234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Ella Mendoza',
                'email' => 'ella@example.com',
                'phone' => '09211234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        User::insert([
            [
                'username' => 'admin01',
                'full_name' => 'System Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'cashier01',
                'full_name' => 'Angela Flores',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'cashier02',
                'full_name' => 'Brian Lim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'staff01',
                'full_name' => 'Clarissa Tan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'manager01',
                'full_name' => 'David Ramos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}