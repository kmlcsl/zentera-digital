<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\AdminUser;

class SettingController extends Controller
{
    /**
     * Display admin settings
     */
    public function index()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            // Get all settings from database
            $settings = Setting::getAll();

            // Fallback to default values if not in database
            $defaultSettings = [
                'whatsapp_number' => '6281330053572',
                'business_name' => 'Zentera Digital',
                'business_email' => 'info@digitalproservices.com',
                'business_address' => 'Medan, North Sumatra, Indonesia',
                'working_hours' => '09:00 - 21:00 WIB',
                'instagram' => '@digitalproservices',
                'facebook' => 'digitalproservices',
                'website_maintenance' => false,
                'auto_reply_whatsapp' => true,
                'email_notifications' => true
            ];

            // Merge with defaults
            $settings = array_merge($defaultSettings, $settings);

            // Get current admin info
            $currentAdmin = null;
            if (Session::get('admin_id')) {
                $currentAdmin = AdminUser::find(Session::get('admin_id'));
            }

            return view('admin.settings.index', compact('settings', 'currentAdmin'));
        } catch (\Exception $e) {
            Log::error('Settings Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Update business settings
     */
    public function updateBusiness(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'working_hours' => 'required|string|max:100',
            'business_address' => 'required|string|max:500',
        ]);

        try {
            // Business settings
            Setting::set('business_name', $request->business_name, 'text', 'business');
            Setting::set('business_email', $request->business_email, 'text', 'business');
            Setting::set('whatsapp_number', $request->whatsapp_number, 'text', 'business');
            Setting::set('working_hours', $request->working_hours, 'text', 'business');
            Setting::set('business_address', $request->business_address, 'text', 'business');

            return back()->with('success', 'Pengaturan bisnis berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pengaturan bisnis: ' . $e->getMessage());
        }
    }

    /**
     * Update social media settings
     */
    public function updateSocialMedia(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'instagram' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'twitter' => 'nullable|string|max:100',
            'youtube' => 'nullable|string|max:100',
            'linkedin' => 'nullable|string|max:100',
        ]);

        try {
            // Social media settings
            Setting::set('instagram', $request->instagram, 'text', 'social');
            Setting::set('facebook', $request->facebook, 'text', 'social');
            Setting::set('twitter', $request->twitter, 'text', 'social');
            Setting::set('youtube', $request->youtube, 'text', 'social');
            Setting::set('linkedin', $request->linkedin, 'text', 'social');

            return back()->with('success', 'Pengaturan media sosial berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pengaturan media sosial: ' . $e->getMessage());
        }
    }

    /**
     * Update website settings
     */
    public function updateWebsite(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            // Website settings (checkboxes)
            Setting::set('website_maintenance', $request->has('website_maintenance'), 'boolean', 'website');
            Setting::set('auto_reply_whatsapp', $request->has('auto_reply_whatsapp'), 'boolean', 'website');
            Setting::set('email_notifications', $request->has('email_notifications'), 'boolean', 'website');
            Setting::set('show_prices', $request->has('show_prices'), 'boolean', 'website');
            Setting::set('allow_registration', $request->has('allow_registration'), 'boolean', 'website');
            Setting::set('debug_mode', $request->has('debug_mode'), 'boolean', 'website');

            // Text settings
            if ($request->has('site_title')) {
                Setting::set('site_title', $request->site_title, 'text', 'website');
            }
            if ($request->has('site_description')) {
                Setting::set('site_description', $request->site_description, 'text', 'website');
            }
            if ($request->has('maintenance_message')) {
                Setting::set('maintenance_message', $request->maintenance_message, 'text', 'website');
            }

            return back()->with('success', 'Pengaturan website berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pengaturan website: ' . $e->getMessage());
        }
    }

    /**
     * Update notification settings
     */
    public function updateNotifications(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            // Notification settings
            Setting::set('email_new_order', $request->has('email_new_order'), 'boolean', 'notifications');
            Setting::set('email_order_completed', $request->has('email_order_completed'), 'boolean', 'notifications');
            Setting::set('whatsapp_notifications', $request->has('whatsapp_notifications'), 'boolean', 'notifications');
            Setting::set('sms_notifications', $request->has('sms_notifications'), 'boolean', 'notifications');

            // Email templates
            if ($request->has('email_template_new_order')) {
                Setting::set('email_template_new_order', $request->email_template_new_order, 'text', 'notifications');
            }
            if ($request->has('email_template_completed')) {
                Setting::set('email_template_completed', $request->email_template_completed, 'text', 'notifications');
            }

            return back()->with('success', 'Pengaturan notifikasi berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pengaturan notifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $adminId = Session::get('admin_id');
        if (!$adminId) {
            return back()->with('error', 'Session tidak valid!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:admin_users,username,' . $adminId,
            'email' => 'required|email|max:255|unique:admin_users,email,' . $adminId,
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $admin = AdminUser::findOrFail($adminId);
            $admin->name = $request->name;
            $admin->username = $request->username;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            $admin->save();

            // Update session data
            Session::put('admin_name', $admin->name);
            Session::put('admin_username', $admin->username);
            Session::put('admin_email', $admin->email);

            return back()->with('success', 'Profil berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate profil: ' . $e->getMessage());
        }
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $adminId = Session::get('admin_id');
        if (!$adminId) {
            return back()->with('error', 'Session tidak valid!');
        }

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $admin = AdminUser::findOrFail($adminId);

            // Verify current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->with('error', 'Password saat ini tidak benar!');
            }

            // Update password
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return back()->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah password: ' . $e->getMessage());
        }
    }

    /**
     * Backup database
     */
    public function backupDatabase()
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Basic backup functionality
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = storage_path('app/backups/');

            // Create backup directory if not exists
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            // Get database configuration
            $dbHost = config('database.connections.mysql.host');
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');

            // Execute mysqldump command
            $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > {$backupPath}{$filename}";
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Backup database berhasil dibuat!',
                    'filename' => $filename
                ]);
            } else {
                return response()->json(['error' => 'Gagal membuat backup database!'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error backup: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Clear Laravel cache
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            Artisan::call('route:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dibersihkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membersihkan cache: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get system info
     */
    public function getSystemInfo()
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $systemInfo = [
                'php_version' => phpversion(),
                'laravel_version' => app()->version(),
                'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'database_version' => DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown',
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'disk_space' => [
                    'free' => disk_free_space('/'),
                    'total' => disk_total_space('/')
                ]
            ];

            return response()->json([
                'success' => true,
                'system_info' => $systemInfo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mendapatkan info sistem: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            $testEmail = $request->test_email;

            // Send test email
            Mail::raw('Ini adalah email test dari sistem admin Zentera Digital.', function ($message) use ($testEmail) {
                $message->to($testEmail)
                    ->subject('Test Email - Zentera Digital Admin');
            });

            return response()->json([
                'success' => true,
                'message' => 'Email test berhasil dikirim ke ' . $testEmail
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim email test: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Test WhatsApp configuration
     */
    public function testWhatsApp()
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $whatsappNumber = Setting::get('whatsapp_number', '6281330053572');
            $message = "Test message dari sistem admin Zentera Digital pada " . date('Y-m-d H:i:s');

            $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);

            return response()->json([
                'success' => true,
                'whatsapp_url' => $whatsappUrl,
                'message' => 'Link WhatsApp test berhasil dibuat!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat link WhatsApp: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Export all settings
     */
    public function exportSettings()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $settings = Setting::all();

            $filename = 'settings_export_' . date('Y-m-d_H-i-s') . '.json';
            $headers = [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $settingsData = [];
            foreach ($settings as $setting) {
                $settingsData[$setting->key] = [
                    'value' => $setting->value,
                    'type' => $setting->type,
                    'group' => $setting->group
                ];
            }

            return response()->json($settingsData, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Import settings from JSON file
     */
    public function importSettings(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'settings_file' => 'required|file|mimes:json|max:2048'
        ]);

        try {
            $file = $request->file('settings_file');
            $content = file_get_contents($file->getPathname());
            $settingsData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'File JSON tidak valid!');
            }

            $importedCount = 0;
            foreach ($settingsData as $key => $data) {
                Setting::set(
                    $key,
                    $data['value'],
                    $data['type'] ?? 'text',
                    $data['group'] ?? 'general'
                );
                $importedCount++;
            }

            return back()->with('success', "Berhasil import {$importedCount} pengaturan!");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Reset settings to default
     */
    public function resetToDefault()
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Default settings
            $defaultSettings = [
                'whatsapp_number' => ['value' => '6281330053572', 'type' => 'text', 'group' => 'business'],
                'business_name' => ['value' => 'Zentera Digital', 'type' => 'text', 'group' => 'business'],
                'business_email' => ['value' => 'info@digitalproservices.com', 'type' => 'text', 'group' => 'business'],
                'business_address' => ['value' => 'Medan, North Sumatra, Indonesia', 'type' => 'text', 'group' => 'business'],
                'working_hours' => ['value' => '09:00 - 21:00 WIB', 'type' => 'text', 'group' => 'business'],
                'instagram' => ['value' => '@digitalproservices', 'type' => 'text', 'group' => 'social'],
                'facebook' => ['value' => 'digitalproservices', 'type' => 'text', 'group' => 'social'],
                'website_maintenance' => ['value' => false, 'type' => 'boolean', 'group' => 'website'],
                'auto_reply_whatsapp' => ['value' => true, 'type' => 'boolean', 'group' => 'website'],
                'email_notifications' => ['value' => true, 'type' => 'boolean', 'group' => 'website']
            ];

            // Clear existing settings
            Setting::truncate();

            // Insert default settings
            foreach ($defaultSettings as $key => $data) {
                Setting::set($key, $data['value'], $data['type'], $data['group']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan berhasil direset ke default!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal reset pengaturan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get setting by key (AJAX)
     */
    public function getSetting(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $key = $request->get('key');
        if (!$key) {
            return response()->json(['error' => 'Key parameter required'], 400);
        }

        try {
            $setting = Setting::where('key', $key)->first();

            if (!$setting) {
                return response()->json(['error' => 'Setting not found'], 404);
            }

            return response()->json([
                'success' => true,
                'setting' => [
                    'key' => $setting->key,
                    'value' => $setting->value,
                    'type' => $setting->type,
                    'group' => $setting->group
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting setting: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update single setting (AJAX)
     */
    public function updateSetting(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'key' => 'required|string',
            'value' => 'required',
            'type' => 'nullable|string',
            'group' => 'nullable|string'
        ]);

        try {
            Setting::set(
                $request->key,
                $request->value,
                $request->type ?? 'text',
                $request->group ?? 'general'
            );

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan berhasil diupdate!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal update pengaturan: ' . $e->getMessage()], 500);
        }
    }
}
