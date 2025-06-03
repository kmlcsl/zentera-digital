<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'service_name',
        'service_category',
        'price',
        'discount',
        'total_amount',
        'status',
        'payment_status',
        'paid_amount',
        'notes',
        'requirements',
        'deadline',
        'started_at',
        'completed_at',
        'assigned_to',
        'files'
    ];

    protected $casts = [
        'files' => 'array',
        'deadline' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'price' => 'decimal:0',
        'discount' => 'decimal:0',
        'total_amount' => 'decimal:0',
        'paid_amount' => 'decimal:0',
    ];

    /**
     * Generate order number otomatis
     */
    public static function generateOrderNumber()
    {
        $lastOrder = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastOrder ? (int)substr($lastOrder->order_number, 4) + 1 : 1;
        return 'ORD-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate total amount setelah diskon
     */
    public function calculateTotal()
    {
        $this->total_amount = $this->price - $this->discount;
        return $this->total_amount;
    }

    /**
     * Get remaining amount yang belum dibayar
     */
    public function getRemainingAmountAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted total
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'in_progress' => 'orange',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentColorAttribute()
    {
        return match ($this->payment_status) {
            'unpaid' => 'red',
            'partial' => 'orange',
            'paid' => 'green',
            'refunded' => 'purple',
            default => 'gray'
        };
    }

    /**
     * Get WhatsApp link untuk customer
     */
    public function getWhatsappLinkAttribute()
    {
        $phone = ltrim($this->customer_phone, '+');
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        $message = "Halo {$this->customer_name}, update pesanan {$this->order_number} - {$this->service_name}. Status: {$this->status}";
        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('service_category', $category);
    }

    /**
     * Scope untuk pesanan yang jatuh tempo
     */
    public function scopeDueSoon($query, $days = 3)
    {
        return $query->where('deadline', '<=', Carbon::now()->addDays($days))
            ->whereIn('status', ['confirmed', 'in_progress']);
    }
}
