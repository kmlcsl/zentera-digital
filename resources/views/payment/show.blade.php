@extends('layouts.app')

@section('title', 'Pembayaran - Order #' . $order->order_number)

@section('content')
    <style>
        .ring-4 {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.3);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.02);
                opacity: 0.8;
            }
        }

        /* Mobile responsive enhancements */
        @media (max-width: 768px) {
            .ring-4 {
                box-shadow: 0 0 0 6px rgba(239, 68, 68, 0.4);
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="gradient-bg pt-20 pb-12 md:pt-24 md:pb-16">
        <div class="container mx-auto px-4 md:px-6 text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 md:mb-6">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">Pembayaran</span>
            </h1>
            <p class="text-base md:text-lg text-gray-200 max-w-2xl mx-auto px-4">
                Selesaikan pembayaran untuk memproses dokumen Anda
            </p>
            <div class="mt-4 inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-2">
                <span class="text-white font-semibold">Order: #{{ $order->order_number }}</span>
            </div>
        </div>
    </section>

    <!-- Payment Section -->
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="max-w-4xl mx-auto">

                <!-- Order Summary -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8 mb-6 md:mb-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-receipt mr-2 text-green-600"></i>Ringkasan Pesanan
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Order Info -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-800 mb-3">
                                    <i class="{{ $order->service_icon }} mr-2 text-blue-600"></i>Detail Layanan
                                </h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Layanan:</span>
                                        <span class="font-medium">{{ $order->service_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">File:</span>
                                        <span class="font-medium">{{ basename($order->document_path) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Harga:</span>
                                        <span class="font-bold text-green-600">{{ $order->formatted_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-800 mb-3">
                                    <i class="fas fa-user mr-2 text-purple-600"></i>Informasi Customer
                                </h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nama:</span>
                                        <span class="font-medium">{{ $order->customer_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">WhatsApp:</span>
                                        <span class="font-medium">{{ $order->customer_phone }}</span>
                                    </div>
                                    @if ($order->notes)
                                        <div class="mt-3">
                                            <span class="text-gray-600">Catatan:</span>
                                            <p class="text-sm text-gray-800 mt-1 bg-yellow-50 p-2 rounded">
                                                {{ $order->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8 mb-6 md:mb-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-credit-card mr-2 text-blue-600"></i>Pilih Metode Pembayaran
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Bank BSI -->
                        <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 transition-colors">
                            <div class="text-center mb-4">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-university text-blue-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-gray-800">{{ $bankAccounts['bsi']['name'] }}</h3>
                            </div>

                            <div class="space-y-3">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="text-center">
                                        <span class="text-xs text-gray-600 block">Nomor Rekening</span>
                                        <span class="text-lg font-bold text-blue-600 block"
                                            id="bsi-number">{{ $bankAccounts['bsi']['account_number'] }}</span>
                                        <button onclick="copyToClipboard('bsi-number')"
                                            class="text-xs text-blue-600 hover:underline mt-1">
                                            <i class="fas fa-copy mr-1"></i>Salin
                                        </button>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="text-sm text-gray-600">Atas Nama:</span>
                                    <span
                                        class="font-semibold text-gray-800 block">{{ $bankAccounts['bsi']['account_name'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- DANA -->
                        <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-green-500 transition-colors">
                            <div class="text-center mb-4">
                                <div
                                    class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-mobile-alt text-green-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-gray-800">{{ $bankAccounts['dana']['name'] }}</h3>
                                <span class="text-xs text-red-500">(QRIS dalam maintenance)</span>
                            </div>

                            <div class="space-y-3">
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="text-center">
                                        <span class="text-xs text-gray-600 block">Nomor DANA</span>
                                        <span class="text-lg font-bold text-green-600 block"
                                            id="dana-number">{{ $bankAccounts['dana']['account_number'] }}</span>
                                        <button onclick="copyToClipboard('dana-number')"
                                            class="text-xs text-green-600 hover:underline mt-1">
                                            <i class="fas fa-copy mr-1"></i>Salin
                                        </button>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="text-sm text-gray-600">Atas Nama:</span>
                                    <span
                                        class="font-semibold text-gray-800 block">{{ $bankAccounts['dana']['account_name'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="mt-8 bg-gradient-to-r from-blue-50 to-green-50 rounded-xl p-6">
                        <h3 class="font-bold text-gray-800 mb-4 text-center">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>Cara Pembayaran
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="text-center">
                                <div
                                    class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <span class="font-bold text-blue-600">1</span>
                                </div>
                                <p class="text-gray-700">Transfer sesuai <strong>nominal exact</strong></p>
                            </div>
                            <div class="text-center">
                                <div
                                    class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <span class="font-bold text-green-600">2</span>
                                </div>
                                <p class="text-gray-700">Screenshot <strong>bukti transfer</strong></p>
                            </div>
                            <div class="text-center">
                                <div
                                    class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <span class="font-bold text-purple-600">3</span>
                                </div>
                                <p class="text-gray-700">Upload bukti di <strong>form bawah</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Payment Proof -->
                <div class="bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-cloud-upload-alt mr-2 text-green-600"></i>Upload Bukti Transfer
                    </h2>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('payment.confirm', $order->order_number) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Payment Method Selection -->
                        <div id="payment-method-section">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-credit-card mr-1 text-blue-600"></i>Metode Pembayaran yang Digunakan
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label
                                    class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50">
                                    <input type="radio" name="payment_method" value="bsi" required class="mr-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-university text-blue-600 mr-2"></i>
                                        <span class="font-medium">Bank BSI</span>
                                    </div>
                                </label>
                                <label
                                    class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-green-50">
                                    <input type="radio" name="payment_method" value="dana" required class="mr-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-mobile-alt text-green-600 mr-2"></i>
                                        <span class="font-medium">DANA</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div id="file-upload-section">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class="fas fa-image mr-1 text-green-600"></i>Bukti Transfer (Screenshot)
                            </label>
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors">
                                <div class="mb-4">
                                    <i class="fas fa-camera text-3xl md:text-4xl text-gray-400 mb-3"></i>
                                    <h4 class="text-base md:text-lg font-semibold text-gray-800 mb-2">Upload Screenshot
                                        Bukti Transfer</h4>
                                    <p class="text-xs md:text-sm text-gray-600 mb-4">Format: JPG, PNG (Max: 5MB)</p>
                                </div>

                                <input type="file" name="payment_proof" id="payment_proof" required
                                    class="block w-full text-xs md:text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs md:file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                    accept="image/jpeg,image/png,image/jpg">

                                <div class="mt-4 text-xs text-gray-500 space-y-1">
                                    <p><strong>Tips:</strong> Pastikan screenshot jelas dan lengkap</p>
                                    <p>Sertakan nominal, nama penerima, dan tanggal/waktu</p>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Confirmation -->
                        <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-6">
                            <h3 class="font-bold text-gray-800 mb-4 text-center">
                                <i class="fas fa-money-bill-wave mr-2 text-green-600"></i>Konfirmasi Nominal Transfer
                            </h3>
                            <div class="text-center">
                                <span class="text-3xl font-bold text-green-600">{{ $order->formatted_price }}</span>
                                <p class="text-sm text-gray-600 mt-2">Pastikan transfer sesuai nominal exact</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button type="submit"
                                class="w-full md:w-auto bg-gradient-to-r from-green-500 to-green-600 text-white py-3 md:py-4 px-6 md:px-8 rounded-lg font-semibold text-sm md:text-lg hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran
                            </button>
                            <p class="text-xs text-gray-500 mt-3">Setelah konfirmasi, Anda akan diarahkan ke WhatsApp untuk
                                verifikasi</p>
                        </div>
                    </form>
                </div>

                <!-- Process Info -->
                <div class="mt-8 bg-white rounded-xl md:rounded-2xl shadow-xl p-6 md:p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-clock mr-2 text-orange-600"></i>Estimasi Waktu Pengerjaan
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-orange-600 text-xl"></i>
                                <!-- Ikon verifikasi pembayaran -->
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Verifikasi Pembayaran</h4>
                            <p class="text-sm text-gray-600">1-2 jam setelah upload bukti</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="{{ $order->service_icon }} text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Proses {{ $order->service_name }}</h4>
                            <p class="text-sm text-gray-600">
                                @if ($order->service_type == 'plagiarism')
                                    1 hari kerja
                                @elseif($order->service_type == 'repair')
                                    1-2 hari kerja
                                @else
                                    1-2 hari kerja
                                @endif
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-paper-plane text-green-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Pengiriman Hasil</h4>
                            <p class="text-sm text-gray-600">Via WhatsApp & Email</p>
                        </div>
                    </div>

                    <!-- Customer Service -->
                    <div class="mt-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 text-center">
                        <h4 class="font-bold text-gray-800 mb-3">
                            <i class="fas fa-headset mr-2 text-blue-600"></i>Butuh Bantuan?
                        </h4>
                        <p class="text-sm text-gray-600 mb-4">Tim support kami siap membantu 24/7</p>
                        <a href="https://wa.me/6281330053572?text={{ urlencode('Halo, saya butuh bantuan untuk order #' . $order->order_number) }}"
                            target="_blank"
                            class="bg-green-500 text-white px-6 py-3 rounded-full font-semibold text-sm hover:bg-green-600 transition-all duration-300 inline-block">
                            <i class="fab fa-whatsapp mr-2"></i>Chat Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Copy to clipboard function
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            const textToCopy = element.textContent;

            navigator.clipboard.writeText(textToCopy).then(function() {
                // Show success message
                const button = element.nextElementSibling;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check mr-1"></i>Tersalin!';
                button.className = button.className.replace('text-blue-600', 'text-green-600').replace(
                    'text-green-600', 'text-green-600');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.className = button.className.replace('text-green-600', elementId.includes(
                        'bsi') ? 'text-blue-600' : 'text-green-600');
                }, 2000);
            });
        }

        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded'); // Debug log

            // File upload preview
            const fileInput = document.getElementById('payment_proof');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        console.log(`File selected: ${file.name} (${fileSize} MB)`);

                        // Show file info
                        const uploadArea = document.querySelector('.border-dashed');
                        uploadArea.classList.add('border-green-400', 'bg-green-50');
                        uploadArea.classList.remove('border-gray-300');

                        // Add file name display
                        const fileName = file.name;
                        const fileInfo = uploadArea.querySelector('.file-info') || document.createElement(
                            'p');
                        fileInfo.className = 'file-info text-sm text-green-600 font-medium mt-2';
                        fileInfo.innerHTML =
                            `<i class="fas fa-check-circle mr-1"></i>File terpilih: ${fileName}`;
                        if (!uploadArea.querySelector('.file-info')) {
                            uploadArea.appendChild(fileInfo);
                        }
                    }
                });
            }

            // Form validation - DEBUGGING VERSION
            // Form validation - MOBILE-FRIENDLY VERSION
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submit triggered');

                    const fileInput = document.getElementById('payment_proof');
                    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

                    // Cek metode pembayaran dulu
                    if (!paymentMethod) {
                        console.log('No payment method selected');
                        e.preventDefault();

                        const paymentSection = document.getElementById('payment-method-section');
                        if (paymentSection) {
                            // Mobile-friendly scroll dengan offset
                            const yOffset = -100; // Offset untuk header/navbar
                            const y = paymentSection.getBoundingClientRect().top + window.pageYOffset +
                                yOffset;

                            window.scrollTo({
                                top: y,
                                behavior: 'smooth'
                            });

                            // Strong visual feedback untuk mobile
                            paymentSection.classList.add('ring-4');
                            paymentSection.style.backgroundColor = '#fef2f2';
                            paymentSection.style.border = '3px solid #ef4444';
                            paymentSection.style.borderRadius = '12px';

                            // Add pulsing animation
                            paymentSection.style.animation = 'pulse 1s infinite';

                            setTimeout(() => {
                                paymentSection.classList.remove('ring-4');
                                paymentSection.style.backgroundColor = '';
                                paymentSection.style.border = '';
                                paymentSection.style.animation = '';
                            }, 4000);
                        }
                        return false;
                    }

                    // Cek file upload
                    if (!fileInput || !fileInput.files[0]) {
                        console.log('No file selected');
                        e.preventDefault();

                        const fileSection = document.getElementById('file-upload-section');
                        if (fileSection) {
                            // Mobile-friendly scroll dengan offset
                            const yOffset = -80;
                            const y = fileSection.getBoundingClientRect().top + window.pageYOffset +
                                yOffset;

                            window.scrollTo({
                                top: y,
                                behavior: 'smooth'
                            });

                            const uploadArea = document.querySelector('.border-dashed');
                            if (uploadArea) {
                                // Strong visual feedback
                                uploadArea.classList.add('ring-4', 'border-red-400');
                                uploadArea.classList.remove('border-gray-300');
                                uploadArea.style.backgroundColor = '#fef2f2';
                                uploadArea.style.border = '3px solid #ef4444';
                                uploadArea.style.animation = 'pulse 1s infinite';

                                // Add error message yang lebih visible
                                const existingError = uploadArea.querySelector('.mobile-error-message');
                                if (existingError) existingError.remove();

                                const errorMsg = document.createElement('div');
                                errorMsg.className =
                                    'mobile-error-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4 text-center font-bold';
                                errorMsg.innerHTML =
                                    '<i class="fas fa-exclamation-triangle mr-2"></i>Silakan upload bukti transfer terlebih dahulu!';
                                uploadArea.appendChild(errorMsg);

                                setTimeout(() => {
                                    uploadArea.classList.remove('ring-4', 'border-red-400');
                                    uploadArea.classList.add('border-gray-300');
                                    uploadArea.style.backgroundColor = '';
                                    uploadArea.style.border = '';
                                    uploadArea.style.animation = '';
                                    const errorToRemove = uploadArea.querySelector(
                                        '.mobile-error-message');
                                    if (errorToRemove) errorToRemove.remove();
                                }, 4000);
                            }
                        }
                        return false;
                    }

                    // Cek ukuran file
                    const fileSize = fileInput.files[0].size / 1024 / 1024;
                    if (fileSize > 5) {
                        console.log('File too large:', fileSize + 'MB');
                        e.preventDefault();

                        const fileSection = document.getElementById('file-upload-section');
                        if (fileSection) {
                            const yOffset = -80;
                            const y = fileSection.getBoundingClientRect().top + window.pageYOffset +
                                yOffset;

                            window.scrollTo({
                                top: y,
                                behavior: 'smooth'
                            });

                            const uploadArea = document.querySelector('.border-dashed');
                            if (uploadArea) {
                                uploadArea.classList.add('ring-4', 'border-red-400');
                                uploadArea.style.animation = 'pulse 1s infinite';

                                // Remove existing error
                                const existingError = uploadArea.querySelector('.mobile-error-message');
                                if (existingError) existingError.remove();

                                // Add prominent error message
                                const errorMsg = document.createElement('div');
                                errorMsg.className =
                                    'mobile-error-message bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4 text-center font-bold';
                                errorMsg.innerHTML =
                                    '<i class="fas fa-exclamation-triangle mr-2"></i>Ukuran file terlalu besar! Maksimal 5MB.';
                                uploadArea.appendChild(errorMsg);

                                setTimeout(() => {
                                    uploadArea.classList.remove('ring-4', 'border-red-400');
                                    uploadArea.classList.add('border-gray-300');
                                    uploadArea.style.animation = '';
                                    const errorToRemove = uploadArea.querySelector(
                                        '.mobile-error-message');
                                    if (errorToRemove) errorToRemove.remove();
                                }, 4000);
                            }
                        }
                        return false;
                    }

                    // Show loading state
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                        submitBtn.disabled = true;

                        setTimeout(() => {
                            if (submitBtn) {
                                submitBtn.innerHTML =
                                    '<i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran';
                                submitBtn.disabled = false;
                            }
                        }, 3000);
                    }
                });
            }

            // Auto select payment method when clicking on card
            document.querySelectorAll('.border-gray-200').forEach(card => {
                card.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;

                        // Update visual state
                        document.querySelectorAll('.border-gray-200').forEach(c => {
                            c.classList.remove('border-blue-500', 'border-green-500',
                                'bg-blue-50', 'bg-green-50');
                            c.classList.add('border-gray-200');
                        });

                        if (radio.value === 'bsi') {
                            this.classList.add('border-blue-500', 'bg-blue-50');
                        } else {
                            this.classList.add('border-green-500', 'bg-green-50');
                        }
                    }
                });
            });

            // Reset button state on page load
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Konfirmasi Pembayaran';
                submitBtn.disabled = false;
            }
        });
    </script>
@endsection
