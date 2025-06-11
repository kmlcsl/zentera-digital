<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Business Settings
            [
                'key' => 'business_name',
                'value' => 'Zentera Digital',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Nama bisnis/perusahaan'
            ],
            [
                'key' => 'business_email',
                'value' => 'info@digitalproservices.com',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Email bisnis utama'
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '6281330053572',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Nomor WhatsApp bisnis'
            ],
            [
                'key' => 'working_hours',
                'value' => '09:00 - 21:00 WIB',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Jam operasional'
            ],
            [
                'key' => 'business_address',
                'value' => 'Medan, North Sumatra, Indonesia',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Alamat bisnis'
            ],

            // Social Media
            [
                'key' => 'instagram',
                'value' => '@digitalproservices',
                'type' => 'text',
                'group' => 'social',
                'description' => 'Username Instagram'
            ],
            [
                'key' => 'facebook',
                'value' => 'digitalproservices',
                'type' => 'text',
                'group' => 'social',
                'description' => 'Username Facebook'
            ],

            // Website Settings
            [
                'key' => 'website_maintenance',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'website',
                'description' => 'Mode maintenance website'
            ],
            [
                'key' => 'auto_reply_whatsapp',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'website',
                'description' => 'Auto reply WhatsApp'
            ],
            [
                'key' => 'email_notifications',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'website',
                'description' => 'Notifikasi email'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
