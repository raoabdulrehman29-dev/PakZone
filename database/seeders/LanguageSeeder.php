<?php

namespace Database\Seeders;

use App\Models\Settings\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'is_default' => true, 'is_active' => true],
            ['code' => 'ur', 'name' => 'Urdu', 'native_name' => 'اردو', 'is_default' => false, 'is_active' => true],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }

        $this->command->info('✅ Languages seeded successfully!');
    }
}
