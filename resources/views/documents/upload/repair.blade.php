@extends('layouts.app')

@section('title', 'Upload Dokumen - ' . $product->name)

@section('content')
    <!-- Hero Section -->
    <section class="gradient-bg pt-24 pb-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                Upload <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">Dokumen</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-200 max-w-2xl mx-auto">
                Upload dokumen Anda dan kami akan segera memproses sesuai kebutuhan
            </p>
        </div>
    </section>

    <!-- Upload Form Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto">

                <!-- Service Info Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                    <div class="text-center mb-8">
                        <div
                            class="w-20 h-20 bg-gradient-to-r {{ $product->color }} rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="{{ $product->icon }} text-white text-2xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-center">
                                <span class="text-2xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                                <span class="text-gray-500 ml-2">per dokumen</span>
                            </div>
                        </div>
                    </div>

                    <!-- Service Features -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <i class="fas fa-clock text-blue-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-800">Pengerjaan Cepat</h4>
                            <p class="text-sm text-gray-600">1-2 hari kerja</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <i class="fas fa-shield-alt text-green-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-800">Kualitas Terjamin</h4>
                            <p class="text-sm text-gray-600">Revisi hingga selesai</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <i class="fas fa-file-alt text-purple-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-800">Format Profesional</h4>
                            <p class="text-sm text-gray-600">Sesuai standar akademik</p>
                        </div>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <i class="fas fa-headset text-orange-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-800">Support 24/7</h4>
                            <p class="text-sm text-gray-600">Konsultasi gratis</p>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-upload mr-2 text-blue-600"></i>Form Upload Dokumen
                    </h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('documents.upload.repair.submit') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- File Upload Section -->
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                            <div class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Upload Dokumen Anda</h4>
                                <p class="text-sm text-gray-600 mb-4">Drag & drop file atau klik untuk browse</p>
                            </div>

                            <input type="file" name="document" id="document" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.doc,.docx,.txt">

                            <div class="mt-4 text-xs text-gray-500">
                                <p><strong>Format yang didukung:</strong> PDF, DOC, DOCX, TXT</p>
                                <p><strong>Ukuran maksimal:</strong> 10MB</p>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-1 text-blue-600"></i>Nama Lengkap
                                </label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fab fa-whatsapp mr-1 text-green-600"></i>No. WhatsApp
                                </label>
                                <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="08123456789">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-1 text-purple-600"></i>Email Address
                            </label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="nama@email.com">
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-1 text-yellow-600"></i>Catatan Khusus (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="4" value="{{ old('notes') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Jelaskan jenis perbaikan yang dibutuhkan, deadline, atau instruksi khusus lainnya..."></textarea>
                        </div>

                        <!-- Terms and Price Info -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-3">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi Penting:
                            </h4>
                            <ul class="text-sm text-gray-600 space-y-2">
                                <li>✓ Harga: <strong>{{ $product->formatted_price }}</strong> per dokumen</li>
                                <li>✓ Pembayaran: Transfer setelah dokumen selesai</li>
                                <li>✓ Waktu pengerjaan: 1-2 hari kerja</li>
                                <li>✓ Revisi gratis hingga Anda puas</li>
                                <li>✓ File akan dikirim via email dan WhatsApp</li>
                            </ul>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit"
                                class="w-full md:w-auto bg-gradient-to-r {{ $product->color }} text-white py-4 px-8 rounded-lg font-semibold text-lg hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-paper-plane mr-2"></i>Upload & Proses Dokumen
                            </button>
                        </div>
                    </form>

                    <!-- Back Link -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('products') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Halaman Layanan
                        </a>
                    </div>
                </div>

                <!-- Process Flow -->
                <div class="mt-12 bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">
                        <i class="fas fa-route mr-2 text-green-600"></i>Alur Proses
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-blue-600">1</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Upload Dokumen</h4>
                            <p class="text-sm text-gray-600">Submit form dengan dokumen Anda</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-green-600">2</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Konfirmasi</h4>
                            <p class="text-sm text-gray-600">Kami hubungi via WhatsApp</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-purple-600">3</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Pengerjaan</h4>
                            <p class="text-sm text-gray-600">Tim ahli proses dokumen</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-orange-600">4</span>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Selesai</h4>
                            <p class="text-sm text-gray-600">Dokumen siap & pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Support -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Butuh Bantuan atau Konsultasi?</h3>
            <p class="text-blue-100 mb-8">Tim support kami siap membantu Anda 24/7</p>
            <a href="https://wa.me/6281330053572?text={{ urlencode('Halo, saya butuh bantuan untuk upload dokumen ' . $product->name) }}"
                target="_blank"
                class="bg-green-500 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-green-600 transition-all duration-300 hover:scale-105 inline-block">
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
                const fileName = file.name;
                const fileType = file.type;

                // You can add visual feedback here
                const uploadArea = document.querySelector('.border-dashed');
                uploadArea.classList.add('border-green-400', 'bg-green-50');
                uploadArea.classList.remove('border-gray-300');
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
    </script>
@endsection
