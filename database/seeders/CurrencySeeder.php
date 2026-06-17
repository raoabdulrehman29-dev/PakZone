<?php

namespace Database\Seeders;

use App\Models\Settings\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            ['code' => 'PKR', 'name' => 'Pakistani Rupee', 'symbol' => 'Rs.', 'exchange_rate' => 1.000000, 'is_default' => true, 'is_active' => true],
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$', 'exchange_rate' => 0.003500, 'is_default' => false, 'is_active' => true],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.003200, 'is_default' => false, 'is_active' => true],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£', 'exchange_rate' => 0.002800, 'is_default' => false, 'is_active' => true],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }

        $this->command->info('✅ Currencies seeded successfully!');
    }
}
