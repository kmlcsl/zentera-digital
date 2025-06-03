@extends('admin.layouts.app')

@section('title', 'Buat Pesanan Baru')
@section('page_title', 'Tambah Pesanan')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Buat Pesanan Baru</h1>
                <p class="text-gray-600 mt-1">Input data customer dan layanan yang dipesan</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.orders.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @csrf

            <!-- Main Form (2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Customer</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan nama lengkap">
                            @error('customer_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp *</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="08123456789 atau +62812345678">
                            @error('customer_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email (Opsional)</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="customer@email.com">
                            @error('customer_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Service Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Layanan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Layanan *</label>
                            <select name="service_category" id="serviceCategory" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Kategori</option>
                                <option value="websites" {{ old('service_category') == 'websites' ? 'selected' : '' }}>
                                    Website</option>
                                <option value="wedding" {{ old('service_category') == 'wedding' ? 'selected' : '' }}>Wedding
                                </option>
                                <option value="documents" {{ old('service_category') == 'documents' ? 'selected' : '' }}>
                                    Documents</option>
                                <option value="software" {{ old('service_category') == 'software' ? 'selected' : '' }}>
                                    Software</option>
                            </select>
                            @error('service_category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan *</label>
                            <select name="service_name" id="serviceName" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih kategori dulu</option>
                            </select>
                            @error('service_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga *</label>
                            <input type="number" name="price" id="servicePrice" value="{{ old('price') }}" required
                                min="0"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0">
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diskon (Rp)</label>
                            <input type="number" name="discount" value="{{ old('discount', 0) }}" min="0"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0">
                            @error('discount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                            <input type="date" name="deadline" value="{{ old('deadline') }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('deadline')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Requirements/Spesifikasi</label>
                            <textarea name="requirements" rows="3"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Detail requirements atau spesifikasi khusus dari customer...">{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea name="notes" rows="3"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Catatan internal atau informasi tambahan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (1 column) -->
            <div class="space-y-6">
                <!-- Quick Fill -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Quick Fill</h2>
                    <div class="space-y-2 text-sm">
                        <button type="button" onclick="fillTestData()"
                            class="w-full bg-gray-100 text-gray-700 py-2 px-3 rounded-md hover:bg-gray-200 text-left">
                            <i class="fas fa-user mr-2"></i>Test Customer
                        </button>
                        <button type="button" onclick="fillOfficeData()"
                            class="w-full bg-blue-100 text-blue-700 py-2 px-3 rounded-md hover:bg-blue-200 text-left">
                            <i class="fab fa-microsoft mr-2"></i>Office Activation
                        </button>
                        <button type="button" onclick="fillWebsiteData()"
                            class="w-full bg-purple-100 text-purple-700 py-2 px-3 rounded-md hover:bg-purple-200 text-left">
                            <i class="fas fa-globe mr-2"></i>Website Portfolio
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga:</span>
                            <span id="summaryPrice" class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Diskon:</span>
                            <span id="summaryDiscount" class="font-medium">- Rp 0</span>
                        </div>
                        <div class="border-t pt-2 flex justify-between">
                            <span class="font-medium text-gray-900">Total:</span>
                            <span id="summaryTotal" class="font-bold text-green-600">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-3">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 font-medium">
                            <i class="fas fa-save mr-2"></i>Buat Pesanan
                        </button>
                        <a href="{{ route('admin.orders.index') }}"
                            class="w-full bg-gray-300 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-400 font-medium text-center block">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Service data
            const services = @json($services);

            // Elements
            const categorySelect = document.getElementById('serviceCategory');
            const serviceSelect = document.getElementById('serviceName');
            const priceInput = document.getElementById('servicePrice');
            const discountInput = document.querySelector('input[name="discount"]');

            // Update service options when category changes
            categorySelect.addEventListener('change', function() {
                const category = this.value;
                serviceSelect.innerHTML = '<option value="">Pilih layanan</option>';
                priceInput.value = '';

                if (category && services[category]) {
                    Object.entries(services[category]).forEach(([name, price]) => {
                        const option = document.createElement('option');
                        option.value = name;
                        option.textContent = name;
                        option.dataset.price = price;
                        serviceSelect.appendChild(option);
                    });
                }
                updateSummary();
            });

            // Update price when service changes
            serviceSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.dataset.price) {
                    priceInput.value = selectedOption.dataset.price;
                }
                updateSummary();
            });

            // Update summary when price or discount changes
            priceInput.addEventListener('input', updateSummary);
            discountInput.addEventListener('input', updateSummary);

            function updateSummary() {
                const price = parseFloat(priceInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const total = price - discount;

                document.getElementById('summaryPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
                document.getElementById('summaryDiscount').textContent = '- Rp ' + discount.toLocaleString('id-ID');
                document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            // Quick fill functions
            function fillTestData() {
                document.querySelector('input[name="customer_name"]').value = 'John Doe';
                document.querySelector('input[name="customer_phone"]').value = '081234567890';
                document.querySelector('input[name="customer_email"]').value = 'john@example.com';
            }

            function fillOfficeData() {
                categorySelect.value = 'software';
                categorySelect.dispatchEvent(new Event('change'));
                setTimeout(() => {
                    serviceSelect.value = 'Microsoft Office Permanent';
                    serviceSelect.dispatchEvent(new Event('change'));
                }, 100);
            }

            function fillWebsiteData() {
                categorySelect.value = 'websites';
                categorySelect.dispatchEvent(new Event('change'));
                setTimeout(() => {
                    serviceSelect.value = 'Website Portfolio';
                    serviceSelect.dispatchEvent(new Event('change'));
                }, 100);
            }
        </script>
    @endpush
@endsection
