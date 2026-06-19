<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            AddressSeeder::class,   // ← Add this BEFORE OrderSeeder
            OrderSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
