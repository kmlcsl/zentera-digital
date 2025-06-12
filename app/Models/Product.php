<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'original_price',
        'features',
        'icon',
        'color',
        'whatsapp_text',
        'show_price',
        'price_label',
        'service_note',
        'is_active',
        'is_featured',
        'sort_order',
        'has_upload_page',
        'upload_route'
    ];

    protected $casts = [
        'features' => 'array',
        'show_price' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'has_upload_page' => 'boolean',
        'price' => 'decimal:0',
        'original_price' => 'decimal:0',
    ];

    /**
     * Scope untuk produk yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Accessor untuk format harga
     */
    public function getFormattedPriceAttribute()
    {
        if (!$this->price) {
            return null;
        }

        $price_prefix = $this->price_label ?? 'Rp';
        return $price_prefix . ' ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Accessor untuk format harga asli
     */
    public function getFormattedOriginalPriceAttribute()
    {
        if (!$this->original_price) {
            return null;
        }

        return 'Rp ' . number_format($this->original_price, 0, ',', '.');
    }

    /**
     * Accessor untuk WhatsApp URL
     */
    public function getWhatsappUrlAttribute()
    {
        $whatsappNumber = config('app.whatsapp_number', '6281330053572');

        // Default text jika whatsapp_text kosong
        $text = $this->whatsapp_text ?: "Halo, saya tertarik dengan layanan {$this->name}. Bisa info lebih detail?";

        $encodedText = urlencode($text);
        return "https://wa.me/{$whatsappNumber}?text={$encodedText}";
    }

    /**
     * Accessor untuk features display
     */
    public function getFeaturesDisplayAttribute()
    {
        if (is_array($this->features)) {
            return implode(', ', $this->features);
        }
        return $this->features ?? '';
    }

    /**
     * Accessor untuk color gradient
     */
    public function getColorAttribute($value)
    {
        $colorMap = [
            'blue' => 'from-blue-500 to-blue-600',
            'green' => 'from-green-500 to-green-600',
            'purple' => 'from-purple-500 to-purple-600',
            'pink' => 'from-pink-500 to-pink-600',
            'red' => 'from-red-500 to-red-600',
            'yellow' => 'from-yellow-500 to-yellow-600',
            'indigo' => 'from-indigo-500 to-indigo-600',
            'gray' => 'from-gray-500 to-gray-600',
        ];

        return $colorMap[$value] ?? 'from-blue-500 to-blue-600';
    }

    /**
     * Accessor untuk icon dengan default
     */
    public function getIconAttribute($value)
    {
        return $value ?: 'fas fa-star';
    }

    /**
     * Accessor untuk features_text (untuk form edit)
     */
    public function getFeaturesTextAttribute()
    {
        if (is_array($this->features)) {
            return implode("\n", $this->features);
        }
        return $this->features ?? '';
    }

    /**
     * Get URL untuk button action (WhatsApp atau Upload Page)
     */
    public function getActionUrlAttribute()
    {
        if ($this->has_upload_page && $this->upload_route && $this->show_price && $this->price) {
            return route($this->upload_route);
        }

        return $this->whatsapp_url;
    }

    /**
     * Get button text berdasarkan action type
     */
    public function getActionButtonTextAttribute()
    {
        if ($this->has_upload_page && $this->show_price && $this->price) {
            return 'Upload Dokumen';
        }

        return $this->show_price && $this->price ? 'Chat Sekarang' : 'Tanya Harga';
    }

    /**
     * Get button icon
     */
    public function getActionButtonIconAttribute()
    {
        if ($this->has_upload_page && $this->show_price && $this->price) {
            return 'fas fa-upload';
        }

        return 'fab fa-whatsapp';
    }

    /**
     * Check if should open in new tab
     */
    public function getActionTargetAttribute()
    {
        if ($this->has_upload_page && $this->show_price && $this->price) {
            return '_self'; // Same tab for upload pages
        }

        return '_blank'; // New tab for WhatsApp
    }
}
