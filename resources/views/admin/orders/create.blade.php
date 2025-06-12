@extends('admin.layouts.app')

@section('title', 'Buat Pesanan Dokumen Manual')
@section('page_title', 'Input Pesanan Manual')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Buat Pesanan Dokumen Manual</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Input pesanan customer yang order via WhatsApp langsung
                </p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
                class="bg-gray-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200 text-sm sm:text-base">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data"
            class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
            @csrf

            <!-- Main Form (2 columns) -->
            <div class="lg:col-span-2 space-y-4 lg:space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Informasi Customer
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Customer *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="Nama lengkap customer">
                            @error('customer_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp *</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="08123456789">
                            @error('customer_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email (Opsional)</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="email@domain.com">
                            @error('customer_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Service Information -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-green-600"></i>
                        Informasi Layanan Dokumen
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan *</label>
                            <select name="service_type" id="serviceType" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Pilih Jenis Layanan</option>
                                <option value="plagiarism_check"
                                    {{ old('service_type') == 'plagiarism_check' ? 'selected' : '' }} data-price="35000">
                                    Cek Plagiarisme (Turnitin) - Rp 35.000
                                </option>
                                <option value="document_repair"
                                    {{ old('service_type') == 'document_repair' ? 'selected' : '' }} data-price="25000">
                                    Perbaikan Dokumen - Rp 25.000
                                </option>
                                <option value="format_toc" {{ old('service_type') == 'format_toc' ? 'selected' : '' }}
                                    data-price="30000">
                                    Format & Daftar Isi - Rp 30.000
                                </option>
                                <option value="custom" {{ old('service_type') == 'custom' ? 'selected' : '' }}>
                                    Layanan Khusus (Custom)
                                </option>
                            </select>
                            @error('service_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga *</label>
                            <input type="number" name="price" id="servicePrice" value="{{ old('price') }}" required
                                min="0" step="1000"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="0">
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diskon (Rp)</label>
                            <input type="number" name="discount" value="{{ old('discount', 0) }}" min="0"
                                step="1000"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="0">
                            @error('discount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Selesai</label>
                            <input type="date" name="estimated_completion"
                                value="{{ old('estimated_completion', date('Y-m-d', strtotime('+2 days'))) }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('estimated_completion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Document Upload -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-upload mr-2 text-purple-600"></i>
                        Upload Dokumen Customer
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Dokumen *</label>
                            <input type="file" name="document" required accept=".pdf,.doc,.docx,.txt"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, TXT (Max: 10MB)</p>
                            @error('document')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Dokumen</label>
                            <textarea name="document_notes" rows="2"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="Catatan khusus tentang dokumen (opsional)">{{ old('document_notes') }}</textarea>
                            @error('document_notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-clipboard-list mr-2 text-orange-600"></i>
                        Informasi Tambahan
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Requirements Customer</label>
                            <textarea name="requirements" rows="3"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="Apa yang diminta customer? Spesifikasi khusus, format yang diinginkan, dll...">{{ old('requirements') }}</textarea>
                            @error('requirements')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Internal</label>
                            <textarea name="internal_notes" rows="2"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="Catatan untuk tim internal, reminder, atau informasi penting lainnya...">{{ old('internal_notes') }}</textarea>
                            @error('internal_notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (1 column) -->
            <div class="space-y-4 lg:space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Quick Actions</h2>
                    <div class="space-y-2 text-sm">
                        <button type="button" onclick="fillSampleData()"
                            class="w-full bg-blue-100 text-blue-700 py-2 px-3 rounded-md hover:bg-blue-200 text-left transition-colors">
                            <i class="fas fa-user-graduate mr-2"></i>Sample Mahasiswa
                        </button>
                        <button type="button" onclick="fillPlagiarismData()"
                            class="w-full bg-green-100 text-green-700 py-2 px-3 rounded-md hover:bg-green-200 text-left transition-colors">
                            <i class="fas fa-search mr-2"></i>Cek Plagiarisme
                        </button>
                        <button type="button" onclick="fillRepairData()"
                            class="w-full bg-yellow-100 text-yellow-700 py-2 px-3 rounded-md hover:bg-yellow-200 text-left transition-colors">
                            <i class="fas fa-tools mr-2"></i>Perbaikan Dokumen
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Layanan:</span>
                            <span id="summaryService" class="font-medium text-right">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga:</span>
                            <span id="summaryPrice" class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Diskon:</span>
                            <span id="summaryDiscount" class="font-medium text-red-600">- Rp 0</span>
                        </div>
                        <div class="border-t pt-2 flex justify-between">
                            <span class="font-medium text-gray-900">Total Bayar:</span>
                            <span id="summaryTotal" class="font-bold text-green-600">Rp 0</span>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-md mt-3">
                            <p class="text-xs text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Customer bayar setelah hasil selesai
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div
                    class="bg-gradient-to-br from-green-50 to-blue-50 rounded-lg shadow p-4 sm:p-6 border border-green-200">
                    <h3 class="text-sm font-semibold text-green-800 mb-2 flex items-center">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Alur Pembayaran
                    </h3>
                    <ol class="text-xs text-green-700 space-y-1">
                        <li>1. Customer kirim dokumen</li>
                        <li>2. Admin proses dokumen</li>
                        <li>3. Kirim hasil ke customer</li>
                        <li>4. Customer transfer pembayaran</li>
                        <li>5. Order complete</li>
                    </ol>
                </div>

                <!-- Submit Buttons -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <div class="space-y-3">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>Buat Pesanan
                        </button>
                        <a href="{{ route('admin.orders.index') }}"
                            class="w-full bg-gray-300 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-400 font-medium text-center block transition-colors">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Elements
            const serviceTypeSelect = document.getElementById('serviceType');
            const priceInput = document.getElementById('servicePrice');
            const discountInput = document.querySelector('input[name="discount"]');

            // Update price when service type changes
            serviceTypeSelect.addEventListener('change', function() {
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
                const serviceText = serviceTypeSelect.options[serviceTypeSelect.selectedIndex].text || '-';
                const price = parseFloat(priceInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const total = Math.max(0, price - discount);

                document.getElementById('summaryService').textContent = serviceText.split(' - ')[0] || '-';
                document.getElementById('summaryPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
                document.getElementById('summaryDiscount').textContent = '- Rp ' + discount.toLocaleString('id-ID');
                document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            // Quick fill functions
            function fillSampleData() {
                document.querySelector('input[name="customer_name"]').value = 'Budi Santoso';
                document.querySelector('input[name="customer_phone"]').value = '081234567890';
                document.querySelector('input[name="customer_email"]').value = 'budi.santoso@gmail.com';
            }

            function fillPlagiarismData() {
                fillSampleData();
                serviceTypeSelect.value = 'plagiarism_check';
                serviceTypeSelect.dispatchEvent(new Event('change'));
                document.querySelector('textarea[name="requirements"]').value =
                    'Cek plagiarisme untuk skripsi, perlu laporan detail dengan persentase similarity dan sumber referensi.';
            }

            function fillRepairData() {
                fillSampleData();
                serviceTypeSelect.value = 'document_repair';
                serviceTypeSelect.dispatchEvent(new Event('change'));
                document.querySelector('textarea[name="requirements"]').value =
                    'Perbaiki format dokumen, font consistency, spacing, dan margin sesuai standar akademik.';
            }

            // Initialize summary on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateSummary();
            });
        </script>
    @endpush
@endsection
