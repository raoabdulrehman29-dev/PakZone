<?php

namespace Database\Seeders;

use App\Models\Settings\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'PakZone', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Pakistan\'s Premier E-Commerce Platform', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'support@pakzone.com', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+92-300-1234567', 'group' => 'general'],
            ['key' => 'currency', 'value' => 'PKR', 'group' => 'general'],
            ['key' => 'currency_symbol', 'value' => 'Rs.', 'group' => 'general'],
            ['key' => 'timezone', 'value' => 'Asia/Karachi', 'group' => 'general'],
            ['key' => 'tax_rate', 'value' => '17', 'group' => 'general'],
            ['key' => 'free_shipping_threshold', 'value' => '5000', 'group' => 'shipping'],
            ['key' => 'default_shipping_cost', 'value' => '150', 'group' => 'shipping'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Settings seeded successfully!');
    }
}
