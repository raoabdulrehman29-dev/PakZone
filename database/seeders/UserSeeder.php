<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create roles first if they don't exist
        $roles = ['super_admin', 'admin', 'manager', 'customer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 1. Super Admin
        $superAdmin = User::create([
            'name' => 'Rao Abdul Rehman',
            'email' => 'raoabdulrehman29@gmail.com',
            'phone' => '03191087089',
            'password' => Hash::make('Admin@123'),
            'status' => 'active',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super_admin');

        // 2. Admin User
        $admin = User::create([
            'name' => 'Ahmed Khan',
            'email' => 'ali@pakzone.com',
            'phone' => '03011234567',
            'password' => Hash::make('Admin@123'),
            'status' => 'active',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // 3. Manager User
        $manager = User::create([
            'name' => 'Fatima Ali',
            'email' => 'manager@pakzone.com',
            'phone' => '03009876543',
            'password' => Hash::make('Manager@123'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('manager');

        // 4-7. Regular Customers
        $customers = [
            ['name' => 'Muhammad Usman', 'email' => 'usman@email.com', 'phone' => '03011111111'],
            ['name' => 'Sara Ahmed', 'email' => 'sara@email.com', 'phone' => '03022222222'],
            ['name' => 'Ali Hassan', 'email' => 'ali@email.com', 'phone' => '03033333333'],
            ['name' => 'Zainab Noor', 'email' => 'zainab@email.com', 'phone' => '03044444444'],
        ];

        foreach ($customers as $customerData) {
            $user = User::create([
                'name' => $customerData['name'],
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
                'password' => Hash::make('Customer@123'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $user->assignRole('customer');
        }

        $this->command->info('✅ Users seeded successfully!');
    }
}
