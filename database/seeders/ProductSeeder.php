<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Website Products
        Product::create([
            'name' => 'Website Portfolio',
            'description' => 'Website profesional untuk menampilkan karya dan profil Anda',
            'category' => 'websites',
            'price' => 500000,
            'original_price' => 750000,
            'features' => ['Desain Responsif', 'Domain + Hosting 1 Tahun', 'SSL Certificate', 'Admin Panel'],
            'icon' => 'fas fa-briefcase',
            'color' => 'from-blue-500 to-blue-600',
            'whatsapp_text' => 'Halo, saya tertarik dengan Website Portfolio (Rp 500.000)',
            'show_price' => true,
            'sort_order' => 1
        ]);

        Product::create([
            'name' => 'Website E-Commerce',
            'description' => 'Toko online lengkap dengan sistem pembayaran dan manajemen produk',
            'category' => 'websites',
            'price' => 1500000,
            'original_price' => 2000000,
            'features' => ['Payment Gateway', 'Manajemen Produk', 'Dashboard Admin', 'Laporan Penjualan'],
            'icon' => 'fas fa-shopping-cart',
            'color' => 'from-purple-500 to-purple-600',
            'whatsapp_text' => 'Halo, saya tertarik dengan Website E-Commerce (Rp 1.500.000)',
            'show_price' => true,
            'sort_order' => 2
        ]);

        Product::create([
            'name' => 'Website Blog',
            'description' => 'Platform blog profesional dengan fitur SEO dan manajemen konten',
            'category' => 'websites',
            'price' => null,
            'original_price' => null,
            'features' => ['SEO Optimized', 'Content Management', 'Comment System', 'Social Media Integration'],
            'icon' => 'fas fa-blog',
            'color' => 'from-green-500 to-green-600',
            'whatsapp_text' => 'Halo, saya tertarik dengan Website Blog. Berapa harganya?',
            'show_price' => false,
            'sort_order' => 3
        ]);

        // Wedding Products
        Product::create([
            'name' => 'Undangan Website Basic',
            'description' => 'Undangan digital sederhana dengan fitur dasar',
            'category' => 'wedding',
            'price' => 150000,
            'features' => ['Desain Elegant', 'Info Acara Lengkap', 'Gallery Foto', 'Maps Lokasi'],
            'icon' => 'fas fa-mobile-alt',
            'color' => 'from-pink-500 to-rose-500',
            'whatsapp_text' => 'Halo, saya tertarik dengan Undangan Website Basic (Rp 150.000)',
            'show_price' => true,
            'sort_order' => 1
        ]);

        Product::create([
            'name' => 'Undangan Website Premium',
            'description' => 'Undangan digital dengan fitur lengkap dan animasi',
            'category' => 'wedding',
            'price' => 250000,
            'features' => ['Animasi & Musik', 'RSVP System', 'Live Streaming', 'Guest Book Digital'],
            'icon' => 'fas fa-star',
            'color' => 'from-purple-500 to-pink-500',
            'whatsapp_text' => 'Halo, saya tertarik dengan Undangan Website Premium (Rp 250.000)',
            'show_price' => true,
            'sort_order' => 2
        ]);

        Product::create([
            'name' => 'Undangan Custom',
            'description' => 'Undangan digital dengan desain sesuai keinginan Anda',
            'category' => 'wedding',
            'price' => null,
            'features' => ['Custom Design', 'Unlimited Revisi', 'All Premium Features', 'Personal Consultation'],
            'icon' => 'fas fa-crown',
            'color' => 'from-indigo-500 to-purple-500',
            'whatsapp_text' => 'Halo, saya tertarik dengan Undangan Custom. Bisa konsultasi dulu?',
            'show_price' => false,
            'sort_order' => 3
        ]);

        // Document Products
        Product::create([
            'name' => 'Perbaikan Dokumen',
            'description' => 'Perbaikan format, tata letak, dan struktur dokumen',
            'category' => 'documents',
            'price' => 25000,
            'features' => null,
            'icon' => 'fas fa-wrench',
            'color' => 'from-blue-500 to-blue-600',
            'whatsapp_text' => 'Halo, saya butuh jasa Perbaikan Dokumen',
            'show_price' => true,
            'price_label' => 'Mulai Rp',
            'sort_order' => 1
        ]);

        Product::create([
            'name' => 'Daftar Isi & Format',
            'description' => 'Pembuatan daftar isi, gambar, tabel, dan lampiran otomatis',
            'category' => 'documents',
            'price' => 50000,
            'features' => null,
            'icon' => 'fas fa-list-ol',
            'color' => 'from-green-500 to-green-600',
            'whatsapp_text' => 'Halo, saya butuh jasa Daftar Isi & Format (Rp 50.000)',
            'show_price' => true,
            'sort_order' => 2
        ]);

        Product::create([
            'name' => 'Cek Plagiarisme Turnitin',
            'description' => 'Pengecekan plagiarisme dengan laporan lengkap',
            'category' => 'documents',
            'price' => 5000,
            'features' => null,
            'icon' => 'fas fa-search',
            'color' => 'from-red-500 to-red-600',
            'whatsapp_text' => 'Halo, saya butuh Cek Plagiarisme Turnitin (Rp 5.000)',
            'show_price' => true,
            'sort_order' => 3
        ]);

        Product::create([
            'name' => 'Parafrase Anti-Plagiat',
            'description' => 'Menulis ulang teks untuk mengurangi similarity',
            'category' => 'documents',
            'price' => null,
            'features' => null,
            'icon' => 'fas fa-sync-alt',
            'color' => 'from-purple-500 to-purple-600',
            'whatsapp_text' => 'Halo, saya butuh jasa Parafrase Anti-Plagiat. Berapa harganya?',
            'show_price' => false,
            'sort_order' => 4
        ]);

        // Software Products
        Product::create([
            'name' => 'Microsoft Office Permanent',
            'description' => 'Aktivasi permanent Word, Excel, PowerPoint dengan update resmi',
            'category' => 'software',
            'price' => 75000,
            'original_price' => 100000,
            'features' => ['License Permanent', 'Update Otomatis', 'All MS Office Apps', 'Garansi Selamanya'],
            'icon' => 'fab fa-microsoft',
            'color' => 'from-blue-600 to-blue-700',
            'whatsapp_text' => 'Halo, saya mau aktivasi Microsoft Office Permanent (Rp 75.000). Apakah bisa via remote atau kunjungan langsung?',
            'show_price' => true,
            'service_note' => 'Tersedia jasa remote dan kunjungan langsung untuk instalasi',
            'sort_order' => 1
        ]);

        Product::create([
            'name' => 'Windows Permanent License',
            'description' => 'Aktivasi Windows 10/11 dengan lisensi permanent dan legal',
            'category' => 'software',
            'price' => 50000,
            'features' => ['Windows 10 & 11', 'License Original', 'Security Update', 'Support Jangka Panjang'],
            'icon' => 'fab fa-windows',
            'color' => 'from-indigo-600 to-purple-600',
            'whatsapp_text' => 'Halo, saya mau aktivasi Windows Permanent (Rp 50.000). Apakah bisa via remote atau kunjungan langsung?',
            'show_price' => true,
            'service_note' => 'Tersedia jasa remote dan kunjungan langsung untuk instalasi',
            'sort_order' => 2
        ]);

        Product::create([
            'name' => 'IDM Permanent + Update',
            'description' => 'Internet Download Manager dengan aktivasi permanent dan bisa update',
            'category' => 'software',
            'price' => null,
            'features' => ['Download Accelerator', 'Auto Update Support', 'Browser Integration', 'Permanent Activation'],
            'icon' => 'fas fa-download',
            'color' => 'from-green-600 to-teal-600',
            'whatsapp_text' => 'Halo, saya mau aktivasi IDM Permanent. Berapa harganya? Apakah bisa via remote atau kunjungan langsung?',
            'show_price' => false,
            'service_note' => 'Tersedia jasa remote dan kunjungan langsung untuk instalasi',
            'sort_order' => 3
        ]);
    }
}
