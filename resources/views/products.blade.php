@extends('layouts.app')

@section('title', 'Layanan & Produk - Zentera Digital')

@section('content')
    <!-- Hero Section -->
    <section class="gradient-bg pt-24 pb-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                Layanan <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">Premium</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-200 max-w-3xl mx-auto">
                Pilih layanan yang sesuai dengan kebutuhan Anda. Klik untuk langsung chat via WhatsApp!
            </p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">

            <!-- Website Services -->
            @if ($products['websites']->count() > 0)
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                        <i class="fas fa-globe mr-3 text-blue-600"></i>Jasa Pembuatan Website
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($products['websites'] as $product)
                            <div
                                class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:scale-105">
                                <div class="bg-gradient-to-r {{ $product->color }} p-6">
                                    <i class="{{ $product->icon }} text-white text-3xl mb-3"></i>
                                    <h3 class="text-xl font-bold text-white">{{ $product->name }}</h3>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-600 mb-4">{{ $product->description }}</p>

                                    <!-- Features List -->
                                    @if (is_array($product->features) && !empty($product->features))
                                        <ul class="text-sm text-gray-600 mb-4 space-y-1">
                                            @foreach ($product->features as $feature)
                                                <li>✓ {{ trim(str_replace(["\r", "\n"], '', $feature)) }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if ($product->show_price && $product->price)
                                        <div class="mb-4">
                                            <span
                                                class="text-2xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                                            @if ($product->original_price)
                                                <span
                                                    class="text-gray-500 line-through ml-2">{{ $product->formatted_original_price }}</span>
                                            @endif
                                        </div>
                                    @elseif(!$product->show_price)
                                        <div class="mb-4">
                                            <span class="text-lg font-semibold text-blue-600">Hubungi Kami</span>
                                        </div>
                                    @endif

                                    <a href="{{ $product->whatsapp_url }}" target="_blank"
                                        class="block w-full bg-gradient-to-r {{ $product->color }} text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 text-center">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        {{ $product->show_price && $product->price ? 'Pesan Sekarang' : 'Tanya Harga' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Wedding Invitation Services -->
            @if ($products['wedding']->count() > 0)
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                        <i class="fas fa-heart mr-3 text-pink-600"></i>Undangan Pernikahan Digital
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($products['wedding'] as $product)
                            <div
                                class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:scale-105">
                                <div class="bg-gradient-to-r {{ $product->color }} p-6">
                                    <i class="{{ $product->icon }} text-white text-3xl mb-3"></i>
                                    <h3 class="text-xl font-bold text-white">{{ $product->name }}</h3>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-600 mb-4">{{ $product->description }}</p>

                                    <!-- Features List -->
                                    @if (is_array($product->features) && !empty($product->features))
                                        <ul class="text-sm text-gray-600 mb-4 space-y-1">
                                            @foreach ($product->features as $feature)
                                                <li>✓ {{ trim(str_replace(["\r", "\n"], '', $feature)) }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if ($product->show_price && $product->price)
                                        <div class="mb-4">
                                            <span
                                                class="text-2xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                                            @if ($product->original_price)
                                                <span
                                                    class="text-gray-500 line-through ml-2">{{ $product->formatted_original_price }}</span>
                                            @endif
                                        </div>
                                    @elseif(!$product->show_price)
                                        <div class="mb-4">
                                            <span class="text-lg font-semibold text-blue-600">Konsultasi Dulu</span>
                                        </div>
                                    @endif

                                    <a href="{{ $product->whatsapp_url }}" target="_blank"
                                        class="block w-full bg-gradient-to-r {{ $product->color }} text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 text-center">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        {{ $product->show_price && $product->price ? 'Pesan Sekarang' : 'Konsultasi' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Document Services -->
            @if ($products['documents']->count() > 0)
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                        <i class="fas fa-file-alt mr-3 text-green-600"></i>Jasa Dokumen Profesional
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($products['documents'] as $product)
                            <div
                                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 group hover:scale-105">
                                <div class="text-center">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-r {{ $product->color }} rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="{{ $product->icon }} text-white text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">{{ $product->description }}</p>

                                    <!-- Features List -->
                                    @if (is_array($product->features) && !empty($product->features))
                                        <ul class="text-xs text-gray-600 mb-4 space-y-1 text-left">
                                            @foreach ($product->features as $feature)
                                                <li>✓ {{ trim(str_replace(["\r", "\n"], '', $feature)) }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if ($product->show_price && $product->price)
                                        <div class="mb-4">
                                            <span
                                                class="text-lg font-semibold text-blue-600">{{ $product->formatted_price }}</span>
                                        </div>
                                    @else
                                        <div class="mb-4">
                                            <span class="text-lg font-semibold text-blue-600">Tanya Harga</span>
                                        </div>
                                    @endif

                                    <a href="{{ $product->whatsapp_url }}" target="_blank"
                                        class="block w-full bg-gradient-to-r {{ $product->color }} text-white py-2 px-4 rounded-lg text-sm font-medium hover:shadow-lg transition-all duration-300 text-center">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        {{ $product->show_price && $product->price ? 'Chat Sekarang' : 'Tanya Harga' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Software Activation Services -->
            @if ($products['software']->count() > 0)
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                        <i class="fas fa-download mr-3 text-orange-600"></i>Aktivasi Software Premium
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($products['software'] as $product)
                            <div
                                class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:scale-105">
                                <div class="bg-gradient-to-r {{ $product->color }} p-6">
                                    <i class="{{ $product->icon }} text-white text-3xl mb-3"></i>
                                    <h3 class="text-xl font-bold text-white">{{ $product->name }}</h3>
                                </div>
                                <div class="p-6">
                                    <p class="text-gray-600 mb-4">{{ $product->description }}</p>

                                    <!-- Features List -->
                                    @if (is_array($product->features) && !empty($product->features))
                                        <ul class="text-sm text-gray-600 mb-4 space-y-1">
                                            @foreach ($product->features as $feature)
                                                <li>✓ {{ trim(str_replace(["\r", "\n"], '', $feature)) }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <!-- Service Note untuk Software -->
                                    @if ($product->service_note)
                                        <div class="text-blue-600 font-medium text-sm mb-4 p-2 bg-blue-50 rounded-lg">
                                            <i class="fas fa-tools mr-1"></i>{{ $product->service_note }}
                                        </div>
                                    @endif

                                    @if ($product->price && $product->price > 0)
                                        <div class="mb-4">
                                            <span
                                                class="text-2xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                                            @if ($product->original_price && $product->original_price > 0)
                                                <span
                                                    class="text-gray-500 line-through ml-2">{{ $product->formatted_original_price }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="mb-4">
                                            <span class="text-lg font-semibold text-blue-600">Hubungi Kami</span>
                                        </div>
                                    @endif

                                    <a href="{{ $product->whatsapp_url }}" target="_blank"
                                        class="block w-full bg-gradient-to-r {{ $product->color }} text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 text-center">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        {{ $product->price && $product->price > 0 ? 'Aktivasi Sekarang' : 'Tanya Harga' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Special Package Section -->
            @if (!empty($packages))
                <div class="mb-16">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl p-8 text-white text-center">
                        <h2 class="text-3xl font-bold mb-4">
                            <i class="fas fa-gift mr-3"></i>Paket Hemat Spesial
                        </h2>
                        <p class="text-xl mb-6">Dapatkan diskon hingga 30% untuk pembelian paket bundling!</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            @foreach ($packages as $package)
                                <div class="bg-white/20 rounded-xl p-4 backdrop-blur-sm">
                                    <h3 class="font-bold text-lg mb-2">{{ $package['name'] }}</h3>
                                    <p class="text-sm">{{ $package['description'] }}</p>
                                    <div class="mt-2">
                                        @if ($package['price'])
                                            <span class="text-2xl font-bold">Rp
                                                {{ number_format($package['price'], 0, ',', '.') }}</span>
                                            @if (isset($package['original_price']) && $package['original_price'])
                                                <span class="text-sm line-through ml-2">Rp
                                                    {{ number_format($package['original_price'], 0, ',', '.') }}</span>
                                            @endif
                                        @else
                                            <span class="text-lg font-semibold">Konsultasi</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo, saya tertarik dengan Paket Hemat Spesial. Bisa info lengkapnya?') }}"
                            target="_blank"
                            class="bg-white text-purple-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 inline-block">
                            <i class="fab fa-whatsapp mr-2"></i>Dapatkan Paket Hemat
                        </a>
                    </div>
                </div>
            @endif

            <!-- FAQ Section -->
            @if (!empty($faqs))
                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                        <i class="fas fa-question-circle mr-3 text-blue-600"></i>Pertanyaan Umum
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($faqs as $faq)
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                                    <i class="{{ $faq['icon'] }} {{ $faq['color'] }} mr-2"></i>{{ $faq['question'] }}
                                </h3>
                                <p class="text-gray-600">{{ $faq['answer'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Contact CTA -->
            <div class="text-center">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white">
                    <h2 class="text-3xl font-bold mb-4">Siap Untuk Memulai Project Anda?</h2>
                    <p class="text-xl mb-6">Konsultasi gratis dan dapatkan quote terbaik untuk kebutuhan Anda!</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo, saya mau konsultasi gratis untuk project saya') }}"
                            target="_blank"
                            class="bg-green-500 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-green-600 transition-all duration-300 hover:scale-105">
                            <i class="fab fa-whatsapp mr-2"></i>Konsultasi Gratis
                        </a>
                        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo, saya mau tanya harga untuk semua layanan') }}"
                            target="_blank"
                            class="bg-white text-purple-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-calculator mr-2"></i>Tanya Harga Lengkap
                        </a>
                    </div>
                    <div class="mt-6 flex flex-wrap justify-center items-center gap-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Kualitas Terjamin</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Pengerjaan Cepat</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-handshake mr-2"></i>
                            <span>Harga Terjangkau</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating WhatsApp Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Halo, saya mau konsultasi tentang layanan Zentera Digital') }}"
            target="_blank"
            class="bg-green-500 text-white p-4 rounded-full shadow-2xl hover:bg-green-600 transition-all duration-300 hover:scale-110 flex items-center justify-center group">
            <i class="fab fa-whatsapp text-2xl"></i>
            <span
                class="absolute right-16 bg-black text-white px-3 py-1 rounded-lg text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                Chat Sekarang!
            </span>
        </a>
    </div>

    <script>
        // Smooth scroll untuk semua link anchor
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.bg-white').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            observer.observe(card);
        });

        // Add click tracking for analytics
        document.querySelectorAll('a[href*="wa.me"]').forEach(link => {
            link.addEventListener('click', function() {
                console.log('WhatsApp link clicked:', this.href);
            });
        });
    </script>
@endsection
