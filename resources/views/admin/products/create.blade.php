@extends('admin.layouts.app')

@section('title', 'Tambah Product')
@section('page_title', 'Tambah Product Baru')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Product Baru</h1>
                <p class="text-gray-600 mt-1">Buat produk/layanan baru untuk ditampilkan di website</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.products.index') }}"
                    class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Ada beberapa kesalahan:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Create Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk/Layanan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Contoh: Website Portfolio">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Kategori</option>
                                <option value="websites" {{ old('category') == 'websites' ? 'selected' : '' }}>Website
                                    Development</option>
                                <option value="wedding" {{ old('category') == 'wedding' ? 'selected' : '' }}>Wedding
                                    Invitation</option>
                                <option value="documents" {{ old('category') == 'documents' ? 'selected' : '' }}>Document
                                    Services</option>
                                <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software &
                                    Tools</option>
                                <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>Design Services
                                </option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Deskripsi produk/layanan...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Pricing -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="price" value="{{ old('price') }}" required min="0"
                                    class="w-full border border-gray-300 rounded-md pl-12 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Masukkan 0 jika gratis atau konsultasi</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Asli (Opsional)
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="original_price" value="{{ old('original_price') }}"
                                    min="0"
                                    class="w-full border border-gray-300 rounded-md pl-12 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Untuk menampilkan diskon coret</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Sort Order
                            </label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0">
                            <p class="text-xs text-gray-500 mt-1">Urutan tampilan (0 = paling atas)</p>
                        </div>
                    </div>

                    <!-- Features -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fitur/Features
                        </label>
                        <textarea name="features" rows="4"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan fitur, pisahkan dengan enter untuk setiap fitur:&#10;✓ Responsive Design&#10;✓ SEO Optimized&#10;✓ Admin Panel">{{ old('features') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Setiap baris akan menjadi 1 fitur terpisah</p>
                    </div>

                    <!-- Visual & Branding -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Icon (Font Awesome)
                            </label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    <i class="fas fa-icons"></i>
                                </span>
                                <input type="text" name="icon" value="{{ old('icon') }}"
                                    class="flex-1 border border-gray-300 rounded-r-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="fas fa-laptop-code">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Contoh: fas fa-laptop-code, fas fa-heart, fas fa-file-alt
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Warna Theme
                            </label>
                            <select name="color"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Warna</option>
                                <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Blue</option>
                                <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Green</option>
                                <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Purple</option>
                                <option value="pink" {{ old('color') == 'pink' ? 'selected' : '' }}>Pink</option>
                                <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>Red</option>
                                <option value="yellow" {{ old('color') == 'yellow' ? 'selected' : '' }}>Yellow</option>
                                <option value="indigo" {{ old('color') == 'indigo' ? 'selected' : '' }}>Indigo</option>
                                <option value="gray" {{ old('color') == 'gray' ? 'selected' : '' }}>Gray</option>
                            </select>
                        </div>
                    </div>

                    <!-- WhatsApp Integration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Template Pesan WhatsApp
                        </label>
                        <textarea name="whatsapp_text" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Halo, saya tertarik dengan layanan [NAMA_PRODUK]. Bisa tolong berikan informasi lebih detail?">{{ old('whatsapp_text') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Template pesan otomatis saat customer klik tombol WhatsApp
                        </p>
                    </div>

                    <!-- Settings -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Tampilan</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_active" class="text-sm font-medium text-gray-700">
                                        Aktif (tampil di website)
                                    </label>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                        {{ old('is_featured') ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_featured" class="text-sm font-medium text-gray-700">
                                        Featured (produk unggulan)
                                    </label>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" name="show_price" id="show_price" value="1"
                                        {{ old('show_price', true) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="show_price" class="text-sm font-medium text-gray-700">
                                        Tampilkan harga di website
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Label Harga
                                </label>
                                <input type="text" name="price_label" value="{{ old('price_label', 'Rp') }}"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Rp">
                                <p class="text-xs text-gray-500 mt-1">Prefix yang muncul sebelum harga (Rp, $, Mulai dari,
                                    dll)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Service Note -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Layanan
                        </label>
                        <textarea name="service_note" rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Catatan tambahan, syarat & ketentuan, atau informasi penting lainnya...">{{ old('service_note') }}</textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pastikan semua informasi sudah benar sebelum menyimpan
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.products.index') }}"
                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Simpan Product
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-eye mr-2"></i>Live Preview
            </h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <div id="preview-content" class="text-center text-gray-500">
                    <i class="fas fa-image text-4xl mb-2"></i>
                    <p>Preview akan muncul di sini saat form diisi</p>
                </div>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-4">
                <i class="fas fa-lightbulb mr-2"></i>Tips Membuat Product
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <ul class="space-y-2">
                    <li><i class="fas fa-check mr-2 text-blue-600"></i>Gunakan nama yang jelas dan mudah dipahami</li>
                    <li><i class="fas fa-check mr-2 text-blue-600"></i>Deskripsi singkat tapi informatif</li>
                    <li><i class="fas fa-check mr-2 text-blue-600"></i>Pilih kategori yang tepat</li>
                </ul>
                <ul class="space-y-2">
                    <li><i class="fas fa-check mr-2 text-blue-600"></i>Set harga yang kompetitif</li>
                    <li><i class="fas fa-check mr-2 text-blue-600"></i>List fitur dengan jelas</li>
                    <li><i class="fas fa-check mr-2 text-blue-600"></i>Template WhatsApp yang menarik</li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Live Preview Update
            function updatePreview() {
                const name = document.querySelector('input[name="name"]').value;
                const category = document.querySelector('select[name="category"]').selectedOptions[0].text;
                const price = document.querySelector('input[name="price"]').value;
                const originalPrice = document.querySelector('input[name="original_price"]').value;
                const description = document.querySelector('textarea[name="description"]').value;
                const icon = document.querySelector('input[name="icon"]').value;
                const color = document.querySelector('select[name="color"]').value;
                const showPrice = document.querySelector('input[name="show_price"]').checked;

                const preview = document.getElementById('preview-content');

                if (name || price) {
                    let priceHtml = '';
                    if (showPrice && price) {
                        if (originalPrice && originalPrice > price) {
                            priceHtml = `
                    <div class="flex items-center justify-center space-x-2 mb-3">
                        <span class="text-lg font-bold text-blue-600">Rp ${parseInt(price).toLocaleString('id-ID')}</span>
                        <span class="text-sm text-gray-500 line-through">Rp ${parseInt(originalPrice).toLocaleString('id-ID')}</span>
                    </div>
                `;
                        } else {
                            priceHtml =
                                `<p class="text-lg font-bold text-blue-600 mb-3">Rp ${parseInt(price).toLocaleString('id-ID')}</p>`;
                        }
                    } else if (price == 0) {
                        priceHtml = `<p class="text-lg font-bold text-green-600 mb-3">Gratis</p>`;
                    }

                    const iconHtml = icon ?
                        `<i class="${icon} text-2xl mb-2 ${color ? `text-${color}-600` : 'text-blue-600'}"></i><br>` : '';

                    preview.innerHTML = `
            <div class="text-center max-w-sm mx-auto p-4 border rounded-lg ${color ? `border-${color}-200` : 'border-blue-200'}">
                ${iconHtml}
                <h4 class="text-xl font-bold text-gray-900 mb-1">${name || 'Nama Produk'}</h4>
                <p class="text-xs text-gray-500 mb-2">${category !== 'Pilih Kategori' ? category : 'Kategori'}</p>
                ${priceHtml}
                <p class="text-gray-600 text-sm mb-3">${description || 'Deskripsi produk...'}</p>
                <button class="bg-green-500 text-white px-4 py-2 rounded-md text-sm hover:bg-green-600 transition-colors">
                    <i class="fab fa-whatsapp mr-1"></i>Pesan Sekarang
                </button>
            </div>
        `;
                }
            }

            // Auto-update preview
            ['input[name="name"]', 'select[name="category"]', 'input[name="price"]', 'input[name="original_price"]',
                'textarea[name="description"]', 'input[name="icon"]', 'select[name="color"]', 'input[name="show_price"]'
            ].forEach(selector => {
                document.querySelector(selector)?.addEventListener('input', updatePreview);
                document.querySelector(selector)?.addEventListener('change', updatePreview);
            });

            // Format price inputs
            ['input[name="price"]', 'input[name="original_price"]'].forEach(selector => {
                document.querySelector(selector)?.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    e.target.value = value;
                    updatePreview();
                });
            });

            // Auto-generate WhatsApp text based on product name
            document.querySelector('input[name="name"]').addEventListener('input', function() {
                const whatsappField = document.querySelector('textarea[name="whatsapp_text"]');
                if (!whatsappField.value && this.value) {
                    whatsappField.value =
                        `Halo, saya tertarik dengan layanan ${this.value}. Bisa tolong berikan informasi lebih detail dan quotation?`;
                }
            });

            // Initial preview
            updatePreview();
        </script>
    @endpush
@endsection
