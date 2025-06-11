<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display the products page
     */
    public function index()
    {
        $whatsappNumber = config('app.whatsapp_number', '6281330053572');

        // Ambil produk dari database, dikelompokkan berdasarkan kategori
        $products = [
            'websites' => Product::active()->byCategory('websites')->orderBy('sort_order')->get(),
            'wedding' => Product::active()->byCategory('wedding')->orderBy('sort_order')->get(),
            'documents' => Product::active()->byCategory('documents')->orderBy('sort_order')->get(),
            'software' => Product::active()->byCategory('software')->orderBy('sort_order')->get(),
        ];

        // Data paket tetap hardcode untuk sekarang (bisa dipindah ke database juga nanti)
        $packages = [
            [
                'name' => 'Paket Mahasiswa',
                'description' => 'Office + Windows + Dokumen',
                'price' => 150000,
                'original_price' => 200000,
                'whatsapp_text' => 'Halo, saya tertarik dengan Paket Mahasiswa (Rp 150.000)'
            ],
            [
                'name' => 'Paket Profesional',
                'description' => 'Website + Office + Windows',
                'price' => 650000,
                'original_price' => 800000,
                'whatsapp_text' => 'Halo, saya tertarik dengan Paket Profesional (Rp 650.000)'
            ],
            [
                'name' => 'Paket Wedding',
                'description' => 'Undangan + Dokumentasi',
                'price' => null,
                'whatsapp_text' => 'Halo, saya tertarik dengan Paket Wedding. Bisa info lengkapnya?'
            ]
        ];

        // FAQ tetap hardcode untuk sekarang
        $faqs = [
            [
                'question' => 'Berapa lama waktu pengerjaan?',
                'answer' => 'Website: 3-7 hari, Undangan: 1-3 hari, Dokumen: 1-2 hari, Aktivasi Software: Instan',
                'icon' => 'fas fa-clock',
                'color' => 'text-blue-600'
            ],
            [
                'question' => 'Apakah ada garansi?',
                'answer' => 'Ya! Semua layanan kami bergaransi. Website 30 hari, Software permanent, Dokumen hingga revisi selesai.',
                'icon' => 'fas fa-shield-alt',
                'color' => 'text-green-600'
            ],
            [
                'question' => 'Bagaimana cara pembayaran?',
                'answer' => 'Transfer Bank, E-Wallet (OVO, GoPay, DANA), atau bisa cicil untuk project besar.',
                'icon' => 'fas fa-credit-card',
                'color' => 'text-purple-600'
            ],
            [
                'question' => 'Apakah bisa revisi?',
                'answer' => 'Tentu! Kami provide revisi sesuai package. Minor revisi gratis, major revisi dengan biaya tambahan.',
                'icon' => 'fas fa-redo',
                'color' => 'text-orange-600'
            ]
        ];

        return view('products', compact('products', 'packages', 'faqs', 'whatsappNumber'));
    }
}
