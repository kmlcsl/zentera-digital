@extends('layouts.app')

@section('title', 'Zentera Digital - Solusi Digital Terpercaya')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg min-h-screen flex items-center relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-32 w-24 h-24 bg-white/5 rounded-full animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-32 left-1/3 w-20 h-20 bg-white/10 rounded-full animate-float" style="animation-delay: 4s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight mb-6">
                    Solusi <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-pink-300">Digital</span>
                    Profesional
                </h1>
                <p class="text-xl lg:text-2xl text-gray-200 mb-8 leading-relaxed">
                    Layanan lengkap untuk kebutuhan digital Anda - dari pembuatan website hingga aktivasi software premium
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('products') }}" class="bg-white text-purple-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 hover-glow">
                        <i class="fas fa-rocket mr-2"></i>Lihat Layanan
                    </a>
                    <a href="https://wa.me/6281383894808" target="_blank" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-purple-600 transition-all duration-300">
                        <i class="fab fa-whatsapp mr-2"></i>Konsultasi Gratis
                    </a>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="relative">
                    <div class="w-96 h-96 bg-white/20 rounded-3xl backdrop-blur-lg border border-white/30 p-8 animate-float">
                        <div class="grid grid-cols-2 gap-4 h-full">
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-globe text-white text-4xl"></i>
                            </div>
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-heart text-white text-4xl"></i>
                            </div>
                            <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-file-alt text-white text-4xl"></i>
                            </div>
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-download text-white text-4xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">
                Mengapa Memilih <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Kami?</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Kami memberikan solusi digital terbaik dengan kualitas premium dan harga terjangkau
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group hover:scale-105 transition-transform duration-300">
                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-zap text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Cepat & Efisien</h3>
                <p class="text-gray-600">Pengerjaan cepat dengan hasil berkualitas tinggi</p>
            </div>

            <div class="text-center group hover:scale-105 transition-transform duration-300">
                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Terpercaya</h3>
                <p class="text-gray-600">Layanan bergaransi dengan kepuasan pelanggan terjamin</p>
            </div>

            <div class="text-center group hover:scale-105 transition-transform duration-300">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-dollar-sign text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Harga Terjangkau</h3>
                <p class="text-gray-600">Kualitas premium dengan harga yang kompetitif</p>
            </div>

            <div class="text-center group hover:scale-105 transition-transform duration-300">
                <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Support 24/7</h3>
                <p class="text-gray-600">Dukungan pelanggan siap membantu kapan saja</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-gray-900 to-gray-800">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
            Siap Untuk Memulai?
        </h2>
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            Hubungi kami sekarang dan dapatkan konsultasi gratis untuk kebutuhan digital Anda
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('products') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-10 py-4 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 hover-glow">
                <i class="fas fa-shopping-cart mr-2"></i>Pilih Layanan
            </a>
            <a href="https://wa.me/6281383894808" target="_blank" class="bg-green-500 text-white px-10 py-4 rounded-full font-semibold hover:bg-green-600 transition-all duration-300 hover-glow">
                <i class="fab fa-whatsapp mr-2"></i>Chat WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
