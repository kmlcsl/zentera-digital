<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentOrder;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show($orderNumber)
    {
        $order = DocumentOrder::where('order_number', $orderNumber)->firstOrFail();

        // Bank accounts info
        $bankAccounts = [
            'bsi' => [
                'name' => 'Bank Syariah Indonesia (BSI)',
                'account_number' => '7254348273', // Ganti dengan nomor rekening asli
                'account_name' => 'MUHAMMAD KAMIL',
                'code' => 'BSI'
            ],
            'dana' => [
                'name' => 'DANA',
                'account_number' => '081330053572', // Ganti dengan nomor DANA asli
                'account_name' => 'ZENTERA DIGITAL'
            ]
        ];

        return view('payment.show', compact('order', 'bankAccounts'));
    }

    public function confirm(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
            'payment_method' => 'required|in:bsi,dana'
        ]);

        $order = DocumentOrder::where('order_number', $orderNumber)->firstOrFail();

        // Store payment proof
        $file = $request->file('payment_proof');
        $filename = 'payment_' . $orderNumber . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment_proofs', $filename, 'public');

        // Update order
        $order->update([
            'payment_status' => 'paid',
            'payment_proof' => $path,
            'paid_at' => now()
        ]);

        // Generate WhatsApp message
        $paymentMethod = $request->payment_method == 'bsi' ? 'BSI' : 'DANA';

        $whatsappMessage = "🎉 *PEMBAYARAN BERHASIL* 🎉\n\n" .
            "📋 *Detail Order:*\n" .
            "🔢 Order: {$order->order_number}\n" .
            "👤 Nama: {$order->customer_name}\n" .
            "📱 Phone: {$order->customer_phone}\n" .
            "🔧 Layanan: {$order->service_name}\n" .
            "💰 Total: {$order->formatted_price}\n" .
            "💳 Metode: {$paymentMethod}\n" .
            "📎 File: " . basename($order->document_path) . "\n" .
            ($order->notes ? "📝 Catatan: {$order->notes}\n" : "") .
            "\n✅ Saya telah melakukan pembayaran!\n" .
            "📸 Bukti transfer sudah diupload\n\n" .
            "Mohon segera diproses ya. Terima kasih! 🙏";

        $whatsappUrl = "https://wa.me/6281330053572?text=" . urlencode($whatsappMessage);

        return redirect()->away($whatsappUrl);
    }
}
