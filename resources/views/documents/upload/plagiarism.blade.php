@extends('layouts.app')

@section('title', 'Upload Dokumen - ' . $product->name)

@section('content')
    <!-- Hero Section -->
    <section class="gradient-bg pt-20 pb-12 md:pt-24 md:pb-16">
        <div class="container mx-auto px-4 md:px-6 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 md:mb-6">
                Cek <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">Plagiarisme</span>
            </h1>
            <p class="text-base md:text-lg lg:text-xl text-gray-200 max-w-2xl mx-auto px-4">
                Upload dokumen untuk pengecekan plagiarisme dengan Turnitin
            </p>
        </div>
    </section>

    <!-- Upload Form Section -->
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="max-w-4xl mx-auto">

                <!-- Service Info Card -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8 mb-6 md:mb-8">
                    <div class="text-center mb-6 md:mb-8">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-r {{ $product->color }} rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="{{ $product->icon }} text-white text-xl md:text-2xl"></i>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-600 mb-4 text-sm md:text-base">{{ $product->description }}</p>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-center">
                                <span
                                    class="text-xl md:text-2xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                                <span class="text-gray-500 ml-2 text-sm md:text-base">per dokumen</span>
                            </div>
                        </div>
                    </div>

                    <!-- Service Features -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6 md:mb-8">
                        <div class="bg-red-50 rounded-lg p-3 md:p-4">
                            <i class="fas fa-search text-red-600 mb-2 text-sm md:text-base"></i>
                            <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Deteksi Akurat</h4>
                            <p class="text-xs text-gray-600">Turnitin Database</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-3 md:p-4">
                            <i class="fas fa-clock text-blue-600 mb-2 text-sm md:text-base"></i>
                            <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Proses Cepat</h4>
                            <p class="text-xs text-gray-600">1 hari kerja</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-3 md:p-4">
                            <i class="fas fa-file-pdf text-green-600 mb-2 text-sm md:text-base"></i>
                            <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Laporan PDF</h4>
                            <p class="text-xs text-gray-600">Detail report</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-3 md:p-4">
                            <i class="fas fa-percentage text-purple-600 mb-2 text-sm md:text-base"></i>
                            <h4 class="font-semibold text-gray-800 text-xs md:text-sm">Analisis Detail</h4>
                            <p class="text-xs text-gray-600">Persentase lengkap</p>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6 text-center">
                        <i class="fas fa-upload mr-2 text-red-600"></i>Form Upload Dokumen
                    </h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('documents.upload.plagiarism.submit') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                        @csrf

                        <!-- File Upload Section -->
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 md:p-8 text-center hover:border-red-400 transition-colors">
                            <div class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-3xl md:text-4xl text-gray-400 mb-3 md:mb-4"></i>
                                <h4 class="text-base md:text-lg font-semibold text-gray-800 mb-2">Upload Dokumen untuk Cek
                                    Plagiarisme</h4>
                                <p class="text-xs md:text-sm text-gray-600 mb-4">Pilih file atau drag & drop</p>
                            </div>

                            <input type="file" name="document" id="document" required
                                class="block w-full text-xs md:text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs md:file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                                accept=".pdf,.doc,.docx,.txt">

                            <div class="mt-4 text-xs text-gray-500 space-y-1">
                                <p><strong>Format:</strong> PDF, DOC, DOCX, TXT</p>
                                <p><strong>Ukuran max:</strong> 10MB</p>
                                <p><strong>Rekomendasi:</strong> DOC/DOCX untuk hasil terbaik</p>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="grid grid-cols-1 gap-4 md:gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1 text-red-600"></i>Nama Lengkap
                                </label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                    class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm md:text-base"
                                    placeholder="Masukkan nama lengkap Anda">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fab fa-whatsapp mr-1 text-green-600"></i>No. WhatsApp
                                </label>
                                <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}"
                                    class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm md:text-base"
                                    placeholder="Contoh: 08123456789">
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-1 text-yellow-600"></i>Catatan Khusus (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                class="w-full px-3 md:px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm md:text-base"
                                placeholder="Deadline, format laporan, atau instruksi khusus...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Terms and Price Info -->
                        <div class="bg-gray-50 rounded-lg p-4 md:p-6">
                            <h4 class="font-semibold text-gray-800 mb-3 text-sm md:text-base">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi Penting:
                            </h4>
                            <ul class="text-xs md:text-sm text-gray-600 space-y-1 md:space-y-2">
                                <li>✓ Harga: <strong>{{ $product->formatted_price }}</strong> per dokumen</li>
                                <li>✓ <strong class="text-green-700">Pembayaran: Transfer SETELAH hasil selesai
                                        dikerjakan</strong></li>
                                <li>✓ Waktu pengerjaan: 1-2 hari kerja (maksimal 48 jam)</li>
                                <li>✓ Laporan dalam format PDF detail dan lengkap</li>
                                <li>✓ Menunjukkan persentase similarity dan sumber referensi</li>
                                <li>✓ Hasil akan dikirim via WhatsApp setelah selesai</li>
                                <li>📋 <em class="text-blue-600">Alur: Upload → Proses → Kirim Hasil → Bayar → Selesai</em>
                                </li>
                            </ul>

                            <div class="mt-4 p-3 bg-blue-50 border-l-4 border-blue-400 rounded">
                                <p class="text-xs md:text-sm text-blue-800">
                                    <i class="fas fa-lightbulb mr-1"></i>
                                    <strong>Catatan:</strong> Anda tidak perlu bayar di muka. Pembayaran dilakukan setelah
                                    menerima dan puas dengan hasil pekerjaan.
                                </p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button type="submit"
                                class="w-full md:w-auto bg-gradient-to-r {{ $product->color }} text-white py-3 md:py-4 px-6 md:px-8 rounded-lg font-semibold text-sm md:text-lg hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-search mr-2"></i>Upload & Cek Plagiarisme
                            </button>
                        </div>
                    </form>

                    <!-- Back Link -->
                    <div class="mt-6 md:mt-8 text-center">
                        <a href="{{ route('products') }}"
                            class="text-red-600 hover:text-red-800 font-medium text-sm md:text-base">
                            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Halaman Layanan
                        </a>
                    </div>
                </div>

                <!-- Process Flow -->
                <div class="mt-8 md:mt-12 bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 md:mb-8 text-center">
                        <i class="fas fa-route mr-2 text-red-600"></i>Alur Proses
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                        <div class="text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                <span class="text-lg md:text-2xl font-bold text-red-600">1</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2 text-xs md:text-sm">Upload Dokumen</h4>
                            <p class="text-xs text-gray-600">Submit file untuk dicek</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                <span class="text-lg md:text-2xl font-bold text-blue-600">2</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2 text-xs md:text-sm">Proses Turnitin</h4>
                            <p class="text-xs text-gray-600">Scan database global</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                <span class="text-lg md:text-2xl font-bold text-green-600">3</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2 text-xs md:text-sm">Generate Report</h4>
                            <p class="text-xs text-gray-600">Laporan PDF detail</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                <span class="text-lg md:text-2xl font-bold text-purple-600">4</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2 text-xs md:text-sm">Kirim Hasil</h4>
                            <p class="text-xs text-gray-600">Via WhatsApp</p>
                        </div>
                    </div>
                </div>

                <!-- Sample Report Preview -->
                <div class="mt-8 md:mt-12 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl md:rounded-2xl p-6 md:p-8">
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6 text-center">
                        <i class="fas fa-file-alt mr-2 text-red-600"></i>Contoh Laporan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="bg-white rounded-lg p-4 md:p-6 shadow-lg">
                            <h4 class="font-semibold text-gray-800 mb-3 md:mb-4 text-sm md:text-base">📊 Similarity Report
                            </h4>
                            <ul class="text-xs md:text-sm text-gray-600 space-y-1 md:space-y-2">
                                <li>• Persentase kesamaan total</li>
                                <li>• Breakdown per sumber</li>
                                <li>• Highlighted text yang sama</li>
                                <li>• URL sumber referensi</li>
                            </ul>
                        </div>
                        <div class="bg-white rounded-lg p-4 md:p-6 shadow-lg">
                            <h4 class="font-semibold text-gray-800 mb-3 md:mb-4 text-sm md:text-base">📈 Detailed Analysis
                            </h4>
                            <ul class="text-xs md:text-sm text-gray-600 space-y-1 md:space-y-2">
                                <li>• Grammar & spell check</li>
                                <li>• Readability score</li>
                                <li>• Word count statistics</li>
                                <li>• Originality assessment</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Support -->
    <section class="py-12 md:py-16 bg-gradient-to-r from-red-600 to-pink-600">
        <div class="container mx-auto px-4 md:px-6 text-center">
            <h3 class="text-xl md:text-2xl font-bold text-white mb-3 md:mb-4">Butuh Bantuan?</h3>
            <p class="text-red-100 mb-6 md:mb-8 text-sm md:text-base">Tim support kami siap membantu Anda 24/7</p>
            <a href="https://wa.me/6281330053572?text={{ urlencode('Halo, saya butuh bantuan untuk cek plagiarisme ' . $product->name) }}"
                target="_blank"
                class="bg-green-500 text-white px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-sm md:text-lg hover:bg-green-600 transition-all duration-300 hover:scale-105 inline-block">
                <i class="fab fa-whatsapp mr-2"></i>Chat Support
            </a>
        </div>
    </section>

    <script>
        // File upload preview
        document.getElementById('document').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                console.log(`File selected: ${file.name} (${fileSize} MB)`);

                // Show file info
                const uploadArea = document.querySelector('.border-dashed');
                uploadArea.classList.add('border-red-400', 'bg-red-50');
                uploadArea.classList.remove('border-gray-300');

                // Add file name display
                const fileName = file.name;
                const fileInfo = uploadArea.querySelector('.file-info') || document.createElement('p');
                fileInfo.className = 'file-info text-sm text-green-600 font-medium mt-2';
                fileInfo.innerHTML = `<i class="fas fa-check-circle mr-1"></i>File terpilih: ${fileName}`;
                if (!uploadArea.querySelector('.file-info')) {
                    uploadArea.appendChild(fileInfo);
                }
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('document');
            if (!fileInput.files[0]) {
                e.preventDefault();
                alert('Silakan pilih file dokumen terlebih dahulu!');
                return false;
            }

            const fileSize = fileInput.files[0].size / 1024 / 1024; // Convert to MB
            if (fileSize > 10) {
                e.preventDefault();
                alert('Ukuran file terlalu besar! Maksimal 10MB.');
                return false;
            }
        });

        // Auto-format phone number
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '0' + value.substring(2);
            }
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            e.target.value = value;
        });
    </script>
@endsection
