@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('page_title', 'Pengaturan Sistem')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
                <p class="text-gray-600 mt-1">Kelola konfigurasi website dan aplikasi</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Settings Form (2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <form method="POST" action="{{ route('admin.settings.business') }}">
                    @csrf

                    <!-- Business Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Bisnis</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bisnis</label>
                                <input type="text" name="business_name" value="{{ $settings['business_name'] }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Bisnis</label>
                                <input type="email" name="business_email" value="{{ $settings['business_email'] }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Kerja</label>
                                <input type="text" name="working_hours" value="{{ $settings['working_hours'] }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <textarea name="business_address" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2">{{ $settings['business_address'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Media Sosial</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                        <i class="fab fa-instagram"></i>
                                    </span>
                                    <input type="text" name="instagram" value="{{ $settings['instagram'] }}"
                                        class="flex-1 border border-gray-300 rounded-r-md px-3 py-2">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                        <i class="fab fa-facebook"></i>
                                    </span>
                                    <input type="text" name="facebook" value="{{ $settings['facebook'] }}"
                                        class="flex-1 border border-gray-300 rounded-r-md px-3 py-2">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Website Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Website</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Mode Maintenance</h3>
                                    <p class="text-sm text-gray-500">Aktifkan untuk menutup sementara website</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="website_maintenance"
                                        {{ $settings['website_maintenance'] ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Auto Reply WhatsApp</h3>
                                    <p class="text-sm text-gray-500">Balasan otomatis untuk pesan WhatsApp</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="auto_reply_whatsapp"
                                        {{ $settings['auto_reply_whatsapp'] ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Notifikasi Email</h3>
                                    <p class="text-sm text-gray-500">Terima notifikasi pesanan via email</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="email_notifications"
                                        {{ $settings['email_notifications'] ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Last updated: {{ now()->format('d M Y, H:i') }} WIB</p>
                            </div>
                            <div class="flex space-x-3">
                                <button type="button"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                    <i class="fas fa-undo mr-2"></i>Reset
                                </button>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Sidebar (1 column) -->
            <div class="space-y-6">
                <!-- Admin Profile -->
                @if (isset($currentAdmin))
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Profil Admin</h2>
                        <div class="text-center">
                            <div
                                class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $currentAdmin->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $currentAdmin->role }}</p>
                            <p class="text-sm text-gray-500">{{ $currentAdmin->email }}</p>
                        </div>
                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Login:</span>
                                <span
                                    class="font-medium">{{ $currentAdmin->last_login_at ? $currentAdmin->last_login_at->format('d M Y, H:i') : 'Never' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span
                                    class="font-medium text-green-600">{{ $currentAdmin->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>
                        </div>
                        <button class="w-full mt-4 bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </button>
                    </div>
                @endif

                <!-- System Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Sistem</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Laravel Version:</span>
                            <span class="font-medium">{{ app()->version() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">PHP Version:</span>
                            <span class="font-medium">{{ PHP_VERSION }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Environment:</span>
                            <span class="font-medium">{{ config('app.env') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Debug Mode:</span>
                            <span class="font-medium {{ config('app.debug') ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ config('app.debug') ? 'On' : 'Off' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
                    <div class="space-y-2">
                        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 text-left">
                            <i class="fas fa-sync-alt mr-2"></i>Clear Cache
                        </button>
                        <button class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 text-left">
                            <i class="fas fa-download mr-2"></i>Backup Database
                        </button>
                        <button class="w-full bg-yellow-600 text-white py-2 px-4 rounded-md hover:bg-yellow-700 text-left">
                            <i class="fas fa-eye mr-2"></i>View Logs
                        </button>
                        <button class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 text-left">
                            <i class="fas fa-chart-bar mr-2"></i>Analytics
                        </button>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                    <h2 class="text-lg font-medium text-red-900 mb-4">Danger Zone</h2>
                    <div class="space-y-3">
                        <button
                            class="w-full bg-red-100 text-red-700 py-2 px-4 rounded-md hover:bg-red-200 text-left border border-red-300">
                            <i class="fas fa-trash mr-2"></i>Reset All Data
                        </button>
                        <button
                            class="w-full bg-red-100 text-red-700 py-2 px-4 rounded-md hover:bg-red-200 text-left border border-red-300">
                            <i class="fas fa-database mr-2"></i>Factory Reset
                        </button>
                    </div>
                    <p class="text-xs text-red-600 mt-2">⚠️ Actions above cannot be undone!</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle switches
            document.querySelectorAll('input[type="checkbox"]').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    console.log('Setting changed:', this.name, this.checked);
                });
            });

            // Quick action buttons
            document.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.textContent.includes('Clear Cache')) {
                        if (confirm('Clear all cache?')) {
                            console.log('Clearing cache...');
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
