<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'service_type',
        'service_name',
        'price',
        'document_path',
        'notes',
        'payment_status',
        'payment_proof',
        'paid_at'
    ];

    protected $casts = [
        'price' => 'decimal:0',
        'paid_at' => 'datetime'
    ];

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'DOC' . $date . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Menunggu Pembayaran</span>',
            'paid' => '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Sedang Diproses</span>',
            'completed' => '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Selesai</span>'
        ];

        return $badges[$this->payment_status] ?? $badges['pending'];
    }

    /**
     * Get service icon
     */
    public function getServiceIconAttribute()
    {
        $icons = [
            'repair' => 'fas fa-wrench',
            'plagiarism' => 'fas fa-search',
            'format' => 'fas fa-list-ol'
        ];

        return $icons[$this->service_type] ?? 'fas fa-file';
    }

    /**
     * Get service color
     */
    public function getServiceColorAttribute()
    {
        $colors = [
            'repair' => 'from-blue-500 to-blue-600',
            'plagiarism' => 'from-red-500 to-red-600',
            'format' => 'from-green-500 to-green-600'
        ];

        return $colors[$this->service_type] ?? 'from-gray-500 to-gray-600';
    }
}
