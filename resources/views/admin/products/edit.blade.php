@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Product</h1>
                <p class="text-gray-600 mt-1">Update informasi produk/layanan</p>
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

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk/Layanan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
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
                                <option value="websites"
                                    {{ old('category', $product->category) == 'websites' ? 'selected' : '' }}>Website
                                    Development</option>
                                <option value="wedding"
                                    {{ old('category', $product->category) == 'wedding' ? 'selected' : '' }}>Wedding
                                    Invitation</option>
                                <option value="documents"
                                    {{ old('category', $product->category) == 'documents' ? 'selected' : '' }}>Document
                                    Services</option>
                                <option value="software"
                                    {{ old('category', $product->category) == 'software' ? 'selected' : '' }}>Software &
                                    Tools</option>
                                <option value="design"
                                    {{ old('category', $product->category) == 'design' ? 'selected' : '' }}>Design Services
                                </option>
                                <option value="other"
                                    {{ old('category', $product->category) == 'other' ? 'selected' : '' }}>Lainnya</option>
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
                            placeholder="Deskripsi produk/layanan...">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Pricing -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                    min="0"
                                    class="w-full border border-gray-300 rounded-md pl-12 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika gratis atau konsultasi</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Discount (%)
                            </label>
                            <input type="number" name="discount_percentage"
                                value="{{ old('discount_percentage', $product->discount_percentage) }}" min="0"
                                max="100"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Sort Order
                            </label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}"
                                min="0"
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
                        <textarea name="features" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Pisahkan dengan enter untuk setiap fitur...">{{ old('features', $product->features_text ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Setiap baris akan menjadi 1 fitur</p>
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
                                <input type="text" name="icon" value="{{ old('icon', $product->icon) }}"
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
                                <option value="blue" {{ old('color', $product->color) == 'blue' ? 'selected' : '' }}>Blue
                                </option>
                                <option value="green" {{ old('color', $product->color) == 'green' ? 'selected' : '' }}>
                                    Green</option>
                                <option value="purple" {{ old('color', $product->color) == 'purple' ? 'selected' : '' }}>
                                    Purple</option>
                                <option value="pink" {{ old('color', $product->color) == 'pink' ? 'selected' : '' }}>Pink
                                </option>
                                <option value="red" {{ old('color', $product->color) == 'red' ? 'selected' : '' }}>Red
                                </option>
                                <option value="yellow" {{ old('color', $product->color) == 'yellow' ? 'selected' : '' }}>
                                    Yellow</option>
                                <option value="indigo" {{ old('color', $product->color) == 'indigo' ? 'selected' : '' }}>
                                    Indigo</option>
                                <option value="gray" {{ old('color', $product->color) == 'gray' ? 'selected' : '' }}>
                                    Gray</option>
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
                            placeholder="Halo, saya tertarik dengan layanan [NAMA_PRODUK]. Bisa tolong berikan informasi lebih detail?">{{ old('whatsapp_text', $product->whatsapp_text) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Template pesan otomatis saat customer klik tombol WhatsApp
                        </p>
                    </div>

                    <!-- Status & Visibility -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="text-sm font-medium text-gray-700">
                                Aktif (tampil di website)
                            </label>
                        </div>

                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="show_price" id="show_price" value="1"
                                {{ old('show_price', $product->show_price) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="show_price" class="text-sm font-medium text-gray-700">
                                Tampilkan Harga (jika ada)
                            </label>
                        </div>

                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_featured" class="text-sm font-medium text-gray-700">
                                Featured (jika ada fitur ini)
                            </label>
                        </div>
                    </div>

                    <!-- Meta Information (Read Only) -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Meta</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div>
                                <label class="block text-gray-600 mb-1">Product ID</label>
                                <p class="text-gray-900 font-mono">#{{ $product->id }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 mb-1">Slug</label>
                                <p class="text-gray-900 font-mono">{{ $product->slug ?? 'Auto generated' }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 mb-1">Dibuat</label>
                                <p class="text-gray-900">{{ $product->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 mb-1">Terakhir Update</label>
                                <p class="text-gray-900">{{ $product->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div
                    class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Semua perubahan akan disimpan setelah klik "Update Product"
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.products.index') }}"
                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-eye mr-2"></i>Preview
            </h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <div id="preview-content" class="text-center text-gray-500">
                    <i class="fas fa-image text-4xl mb-2"></i>
                    <p>Preview akan muncul di sini saat form diisi</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto update preview
            function updatePreview() {
                const name = document.querySelector('input[name="name"]').value;
                const category = document.querySelector('select[name="category"]').selectedOptions[0].text;
                const price = document.querySelector('input[name="price"]').value;
                const description = document.querySelector('textarea[name="description"]').value;

                const preview = document.getElementById('preview-content');

                if (name || price) {
                    preview.innerHTML = `
            <div class="text-left">
                <h4 class="text-xl font-bold text-gray-900">${name || 'Nama Produk'}</h4>
                <p class="text-sm text-gray-500 mb-2">${category !== 'Pilih Kategori' ? category : 'Kategori'}</p>
                <p class="text-lg font-bold text-blue-600 mb-3">
                    ${price ? 'Rp ' + parseInt(price).toLocaleString('id-ID') : 'Gratis/Konsultasi'}
                </p>
                <p class="text-gray-600 text-sm">${description || 'Deskripsi produk...'}</p>
            </div>
        `;
                }
            }

            // Add event listeners
            document.querySelector('input[name="name"]').addEventListener('input', updatePreview);
            document.querySelector('select[name="category"]').addEventListener('change', updatePreview);
            document.querySelector('input[name="price"]').addEventListener('input', updatePreview);
            document.querySelector('textarea[name="description"]').addEventListener('input', updatePreview);

            // Initial preview
            updatePreview();

            // Format price input
            document.querySelector('input[name="price"]').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
            });

            // Auto generate slug (optional)
            document.querySelector('input[name="name"]').addEventListener('input', function(e) {
                // Could auto-generate slug here if needed
            });
        </script>
    @endpush
@endsection
