<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'PakZone', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Pakistan\'s Premier E-Commerce Platform', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => '/images/logo.png', 'group' => 'general'],
            ['key' => 'favicon', 'value' => '/images/favicon.png', 'group' => 'general'],

            // Contact Settings
            ['key' => 'contact_email', 'value' => 'support@pakzone.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+92-300-1234567', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => '123 Main Street, Karachi, Pakistan', 'group' => 'contact'],

            // Currency & Tax
            ['key' => 'currency', 'value' => 'PKR', 'group' => 'general'],
            ['key' => 'currency_symbol', 'value' => 'Rs.', 'group' => 'general'],
            ['key' => 'timezone', 'value' => 'Asia/Karachi', 'group' => 'general'],
            ['key' => 'tax_rate', 'value' => '17', 'group' => 'general'],

            // Shipping Settings
            ['key' => 'free_shipping_threshold', 'value' => '5000', 'group' => 'shipping'],
            ['key' => 'default_shipping_cost', 'value' => '150', 'group' => 'shipping'],

            // Other Settings
            ['key' => 'maintenance_mode', 'value' => 'false', 'group' => 'system'],
            ['key' => 'allow_registration', 'value' => 'true', 'group' => 'system'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Settings seeded successfully!');
    }
}
