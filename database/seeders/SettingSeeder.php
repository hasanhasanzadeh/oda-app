<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'title' => 'Title test',
            'short_text' => 'Short text test',
            'url' => 'localhost',
            'email' => 'info@test.com',
            'tel' => '09123456789',
            'support_text' => 'support test',
            'address' => 'address test',
            'description' => 'desc test',
            'copy_right' => 'copytight test'
        ]);
    }
}
