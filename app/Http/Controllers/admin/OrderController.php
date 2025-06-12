<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentOrder;

class OrderController extends Controller
{
    /**
     * Display orders list
     */
    public function index()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            // Ambil semua document orders dengan pagination
            $orders = DocumentOrder::latest()->paginate(20);

            // Statistik berdasarkan payment_status
            $stats = [
                'total_orders' => DocumentOrder::count(),
                'pending_orders' => DocumentOrder::where('payment_status', 'pending')->count(),
                'paid_orders' => DocumentOrder::where('payment_status', 'paid')->count(),
                'completed_orders' => DocumentOrder::where('payment_status', 'completed')->count(),
                'total_revenue' => DocumentOrder::where('payment_status', 'completed')->sum('price'),
            ];

            return view('admin.orders.index', compact('orders', 'stats'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Show create form
     */
    public function create()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Services untuk document processing
        $services = [
            'repair' => ['name' => 'Perbaikan Dokumen', 'price' => 75000],
            'plagiarism' => ['name' => 'Cek Plagiarisme Turnitin', 'price' => 35000],
            'format' => ['name' => 'Daftar Isi & Format', 'price' => 50000],
        ];

        return view('admin.orders.create', compact('services'));
    }

    /**
     * Store new order - UPDATED untuk DocumentOrder
     */
    public function store(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_type' => 'required|in:repair,plagiarism,format',
            'price' => 'required|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
            'notes' => 'nullable|string'
        ]);

        try {
            // Handle file upload jika ada
            $documentPath = null;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $documentPath = $file->storeAs('documents/admin', $filename, 'public');
            }

            // Create DocumentOrder
            $order = DocumentOrder::create([
                'order_number' => DocumentOrder::generateOrderNumber(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'service_type' => $request->service_type,
                'service_name' => $this->getServiceName($request->service_type),
                'price' => $request->price,
                'document_path' => $documentPath,
                'notes' => $request->notes,
                'payment_status' => 'pending'
            ]);

            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show order details - UPDATED untuk DocumentOrder
     */
    public function show($id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $order = DocumentOrder::findOrFail($id);
            return view('admin.orders.show', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak ditemukan!');
        }
    }

    /**
     * Show edit form - UPDATED untuk DocumentOrder
     */
    public function edit($id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $order = DocumentOrder::findOrFail($id);
            return view('admin.orders.edit', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak ditemukan!');
        }
    }

    /**
     * Update order - UPDATED untuk DocumentOrder
     */
    public function update(Request $request, $id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_type' => 'required|in:repair,plagiarism,format',
            'price' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,completed',
            'notes' => 'nullable|string'
        ]);

        try {
            $order = DocumentOrder::findOrFail($id);

            $order->update([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'service_type' => $request->service_type,
                'service_name' => $this->getServiceName($request->service_type),
                'price' => $request->price,
                'payment_status' => $request->payment_status,
                'notes' => $request->notes
            ]);

            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate pesanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete order - UPDATED untuk DocumentOrder
     */
    public function destroy($id)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $order = DocumentOrder::findOrFail($id);
            $orderNumber = $order->order_number;

            // Delete associated files
            if ($order->document_path && Storage::disk('public')->exists($order->document_path)) {
                Storage::disk('public')->delete($order->document_path);
            }

            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan ' . $orderNumber . ' berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus pesanan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update payment status via AJAX - NEW METHOD
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'payment_status' => 'required|in:pending,paid,completed'
        ]);

        try {
            $order = DocumentOrder::findOrFail($id);
            $order->payment_status = $request->payment_status;

            // Set paid_at timestamp when status changes to paid
            if ($request->payment_status === 'paid' && $order->payment_status !== 'paid') {
                $order->paid_at = now();
            }

            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Status pembayaran berhasil diupdate!',
                'new_status' => $order->status_badge
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal update status: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get order details via AJAX - NEW METHOD
     */
    public function getOrderDetails($id)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $order = DocumentOrder::findOrFail($id);

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'customer_phone' => $order->customer_phone,
                    'service_name' => $order->service_name,
                    'service_type' => $order->service_type,
                    'price' => $order->formatted_price,
                    'payment_status' => $order->payment_status,
                    'notes' => $order->notes,
                    'document_path' => $order->document_path ? Storage::url($order->document_path) : null,
                    'payment_proof' => $order->payment_proof ? Storage::url($order->payment_proof) : null,
                    'created_at' => $order->created_at->format('d M Y, H:i'),
                    'paid_at' => $order->paid_at ? $order->paid_at->format('d M Y, H:i') : null
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order tidak ditemukan!'], 404);
        }
    }

    /**
     * Download document or payment proof - NEW METHOD
     */
    public function downloadFile($id, $type)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $order = DocumentOrder::findOrFail($id);

            if ($type === 'document' && $order->document_path) {
                $filePath = storage_path('app/public/' . $order->document_path);
                $fileName = basename($order->document_path);

                if (file_exists($filePath)) {
                    return response()->download($filePath, $fileName);
                }
            }

            if ($type === 'payment' && $order->payment_proof) {
                $filePath = storage_path('app/public/' . $order->payment_proof);
                $fileName = basename($order->payment_proof);

                if (file_exists($filePath)) {
                    return response()->download($filePath, $fileName);
                }
            }

            return back()->with('error', 'File tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunduh file: ' . $e->getMessage());
        }
    }

    /**
     * Filter orders - NEW METHOD
     */
    public function filter(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $query = DocumentOrder::query();

            // Filter by payment status
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            // Filter by service type
            if ($request->filled('service_type')) {
                $query->where('service_type', $request->service_type);
            }

            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Search by customer name or order number
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                        ->orWhere('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            }

            $orders = $query->latest()->paginate(20);

            // Statistik untuk filtered results
            $stats = [
                'total_orders' => $query->count(),
                'pending_orders' => (clone $query)->where('payment_status', 'pending')->count(),
                'paid_orders' => (clone $query)->where('payment_status', 'paid')->count(),
                'completed_orders' => (clone $query)->where('payment_status', 'completed')->count(),
                'total_revenue' => (clone $query)->where('payment_status', 'completed')->sum('price'),
            ];

            return view('admin.orders.index', compact('orders', 'stats'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memfilter data: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to get service name
     */
    private function getServiceName($serviceType)
    {
        $services = [
            'repair' => 'Perbaikan Dokumen',
            'plagiarism' => 'Cek Plagiarisme Turnitin',
            'format' => 'Daftar Isi & Format'
        ];

        return $services[$serviceType] ?? 'Unknown Service';
    }
}
