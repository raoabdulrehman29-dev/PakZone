<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use App\Models\Customer\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('status', 'active')->get();

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ No users found. Skipping addresses.');
            return;
        }

        $addressTypes = ['shipping', 'billing'];

        foreach ($users as $user) {
            // Create 1-3 addresses per user
            $addressCount = rand(1, 3);

            for ($i = 0; $i < $addressCount; $i++) {
                Address::create([
                    'user_id' => $user->id,
                    'type' => $addressTypes[array_rand($addressTypes)],
                    'name' => $user->name,
                    'phone' => $user->phone ?? '0300' . rand(1000000, 9999999),
                    'address' => $this->getRandomAddress(),
                    'city' => $this->getRandomCity(),
                    'state' => $this->getRandomState(),
                    'country' => 'Pakistan',
                    'pincode' => rand(10000, 99999),
                    'is_default' => $i === 0, // First address is default
                ]);
            }
        }

        $this->command->info('✅ Addresses seeded successfully!');
    }

    private function getRandomAddress()
    {
        $addresses = [
            'House #' . rand(1, 100) . ', Street ' . rand(1, 20),
            'Flat ' . rand(1, 50) . ', Building ' . rand(1, 30),
            'Plot ' . rand(1, 200) . ', Block ' . chr(rand(65, 90)),
            'Shop #' . rand(1, 50) . ', Market ' . rand(1, 10),
            'Office #' . rand(1, 100) . ', Tower ' . rand(1, 20),
        ];
        return $addresses[array_rand($addresses)];
    }

    private function getRandomCity()
    {
        $cities = ['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan', 'Hyderabad', 'Peshawar', 'Quetta', 'Gujranwala'];
        return $cities[array_rand($cities)];
    }

    private function getRandomState()
    {
        $states = ['Sindh', 'Punjab', 'KPK', 'Balochistan', 'Gilgit-Baltistan', 'AJK', 'Islamabad'];
        return $states[array_rand($states)];
    }
}
