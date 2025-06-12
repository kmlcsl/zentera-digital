<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DocumentOrder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DocumentUploadController extends Controller
{
    public function repairForm()
    {
        try {
            $product = Product::where('upload_route', 'documents.upload.repair')->first();

            if (!$product) {
                $product = Product::where('name', 'Perbaikan Dokumen')->first();
            }

            if (!$product) {
                return redirect()->route('products')->with('error', 'Layanan tidak ditemukan');
            }

            return view('documents.upload.repair', compact('product'));
        } catch (\Exception $e) {
            Log::error('Repair form error: ' . $e->getMessage());
            return redirect()->route('products')->with('error', 'Terjadi kesalahan sistem');
        }
    }

    public function formatForm()
    {
        try {
            $product = Product::where('upload_route', 'documents.upload.format')->first();

            if (!$product) {
                $product = Product::where('name', 'Daftar Isi & Format')->first();
            }

            if (!$product) {
                return redirect()->route('products')->with('error', 'Layanan tidak ditemukan');
            }

            return view('documents.upload.format', compact('product'));
        } catch (\Exception $e) {
            Log::error('Format form error: ' . $e->getMessage());
            return redirect()->route('products')->with('error', 'Terjadi kesalahan sistem');
        }
    }

    public function plagiarismForm()
    {
        try {
            $product = Product::where('upload_route', 'documents.upload.plagiarism')->first();

            if (!$product) {
                $product = Product::where('name', 'Cek Plagiarisme Turnitin')->first();
            }

            if (!$product) {
                // Fallback untuk debugging
                Log::warning('Product not found, creating fallback');
                $product = (object) [
                    'name' => 'Cek Plagiarisme Turnitin',
                    'description' => 'Layanan pengecekan plagiarisme menggunakan Turnitin',
                    'price' => 25000,
                    'formatted_price' => 'Rp 25.000',
                    'color' => 'from-red-500 to-pink-500',
                    'icon' => 'fas fa-search'
                ];
            }

            return view('documents.upload.plagiarism', compact('product'));
        } catch (\Exception $e) {
            Log::error('Plagiarism form error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('products')->with('error', 'Terjadi kesalahan sistem');
        }
    }

    public function repairSubmit(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'notes' => 'nullable|string'
            ]);

            // Get product info
            $product = Product::where('name', 'Perbaikan Dokumen')->first();

            if (!$product) {
                return back()->with('error', 'Layanan tidak tersedia');
            }

            // Store uploaded file - FIXED for Vercel
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Use tmp directory instead of storage/app/public
            $tempPath = sys_get_temp_dir() . '/' . $filename;
            $file->move(sys_get_temp_dir(), $filename);

            // For production, you might want to upload to cloud storage
            // For now, we'll just store the filename
            $path = 'documents/repair/' . $filename;

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

            Log::info('Order created successfully: ' . $order->order_number);

            // Redirect to payment page
            return redirect()->route('payment.show', $order->order_number);
        } catch (\Exception $e) {
            Log::error('Repair submit error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function formatSubmit(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'notes' => 'nullable|string'
            ]);

            $product = Product::where('name', 'Daftar Isi & Format')->first();

            if (!$product) {
                return back()->with('error', 'Layanan tidak tersedia');
            }

            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Use tmp directory
            $tempPath = sys_get_temp_dir() . '/' . $filename;
            $file->move(sys_get_temp_dir(), $filename);

            $path = 'documents/format/' . $filename;

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
        } catch (\Exception $e) {
            Log::error('Format submit error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function plagiarismSubmit(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'notes' => 'nullable|string'
            ]);

            $product = Product::where('name', 'Cek Plagiarisme Turnitin')->first();

            if (!$product) {
                // Fallback price if product not found
                $defaultPrice = 25000;
                Log::warning('Product not found, using default price: ' . $defaultPrice);
            } else {
                $defaultPrice = $product->price;
            }

            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Use tmp directory for Vercel compatibility
            $tempPath = sys_get_temp_dir() . '/' . $filename;
            $file->move(sys_get_temp_dir(), $filename);

            $path = 'documents/plagiarism/' . $filename;

            $order = DocumentOrder::create([
                'order_number' => DocumentOrder::generateOrderNumber(),
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'service_type' => 'plagiarism',
                'service_name' => 'Cek Plagiarisme Turnitin',
                'price' => $defaultPrice,
                'document_path' => $path,
                'notes' => $request->notes,
                'payment_status' => 'pending'
            ]);

            Log::info('Plagiarism order created: ' . $order->order_number);

            return redirect()->route('payment.show', $order->order_number);
        } catch (\Exception $e) {
            Log::error('Plagiarism submit error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
