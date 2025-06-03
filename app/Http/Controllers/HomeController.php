<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Data untuk halaman home
        $services = [
            'websites' => [
                'total' => 3,
                'featured' => [
                    'Portfolio Website',
                    'E-Commerce Website',
                    'Blog Website'
                ]
            ],
            'documents' => [
                'total' => 4,
                'featured' => [
                    'Perbaikan Dokumen',
                    'Daftar Isi Otomatis',
                    'Cek Plagiarisme',
                    'Parafrase Anti-Plagiat'
                ]
            ],
            'software' => [
                'total' => 3,
                'featured' => [
                    'Microsoft Office',
                    'Windows License',
                    'IDM Permanent'
                ]
            ],
            'wedding' => [
                'total' => 3,
                'featured' => [
                    'Undangan Basic',
                    'Undangan Premium',
                    'Undangan Custom'
                ]
            ]
        ];

        $stats = [
            'happy_clients' => 500,
            'projects_completed' => 750,
            'years_experience' => 3,
            'success_rate' => 98
        ];

        $testimonials = [
            [
                'name' => 'Ahmad Ridwan',
                'service' => 'Website E-Commerce',
                'rating' => 5,
                'comment' => 'Pelayanan sangat memuaskan! Website toko online saya jadi professional dan penjualan meningkat drastis.'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'service' => 'Undangan Pernikahan',
                'rating' => 5,
                'comment' => 'Undangan digitalnya cantik banget! Tamu-tamu pada kagum dan proses RSVP jadi mudah.'
            ],
            [
                'name' => 'Budi Santoso',
                'service' => 'Aktivasi Office',
                'rating' => 5,
                'comment' => 'Cepat, murah, dan permanent! Office saya sekarang genuine dan bisa update terus.'
            ]
        ];

        return view('home', compact('services', 'stats', 'testimonials'));
    }
}
