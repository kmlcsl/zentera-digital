<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DocumentOrder;
use Illuminate\Support\Facades\Storage;

class DocumentUploadController extends Controller
{
    public function repairForm()
    {
        $product = Product::where('upload_route', 'documents.upload.repair')->first();

        if (!$product) {
            $product = Product::where('name', 'Perbaikan Dokumen')->first();
        }

        if (!$product) {
            return redirect()->route('products')->with('error', 'Layanan tidak ditemukan');
        }

        return view('documents.upload.repair', compact('product'));
    }

    public function formatForm()
    {
        $product = Product::where('upload_route', 'documents.upload.format')->first();

        if (!$product) {
            $product = Product::where('name', 'Daftar Isi & Format')->first();
        }

        if (!$product) {
            return redirect()->route('products')->with('error', 'Layanan tidak ditemukan');
        }

        return view('documents.upload.format', compact('product'));
    }

    public function plagiarismForm()
    {
        $product = Product::where('upload_route', 'documents.upload.plagiarism')->first();

        if (!$product) {
            $product = Product::where('name', 'Cek Plagiarisme Turnitin')->first();
        }

        if (!$product) {
            return redirect()->route('products')->with('error', 'Layanan tidak ditemukan');
        }

        return view('documents.upload.plagiarism', compact('product'));
    }

    public function repairSubmit(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        // Get product info
        $product = Product::where('name', 'Perbaikan Dokumen')->first();

        // Store uploaded file
        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/repair', $filename, 'public');

        // Create order
        $order = DocumentOrder::create([
            'order_number' => DocumentOrder::generateOrderNumber(),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'service_type' => 'repair',
            'service_name' => 'Perbaikan Dokumen',
            'price' => $product->price,
            'document_path' => $path,
            'notes' => $request->notes,
            'payment_status' => 'pending'
        ]);

        // Redirect to payment page
        return redirect()->route('payment.show', $order->order_number);
    }

    public function formatSubmit(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $product = Product::where('name', 'Daftar Isi & Format')->first();

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/format', $filename, 'public');

        $order = DocumentOrder::create([
            'order_number' => DocumentOrder::generateOrderNumber(),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'service_type' => 'format',
            'service_name' => 'Daftar Isi & Format',
            'price' => $product->price,
            'document_path' => $path,
            'notes' => $request->notes,
            'payment_status' => 'pending'
        ]);

        return redirect()->route('payment.show', $order->order_number);
    }

    public function plagiarismSubmit(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $product = Product::where('name', 'Cek Plagiarisme Turnitin')->first();

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents/plagiarism', $filename, 'public');

        $order = DocumentOrder::create([
            'order_number' => DocumentOrder::generateOrderNumber(),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'service_type' => 'plagiarism',
            'service_name' => 'Cek Plagiarisme Turnitin',
            'price' => $product->price,
            'document_path' => $path,
            'notes' => $request->notes,
            'payment_status' => 'pending'
        ]);

        return redirect()->route('payment.show', $order->order_number);
    }
}
