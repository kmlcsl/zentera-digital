<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

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
            // Ambil semua orders
            $orders = Order::latest()->paginate(20);

            // Statistik sederhana
            $stats = [
                'total_orders' => Order::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'completed_orders' => Order::where('status', 'completed')->count(),
                'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
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

        // Services sederhana
        $services = [
            'Website Portfolio' => 500000,
            'Website E-Commerce' => 1500000,
            'Undangan Basic' => 150000,
            'Microsoft Office' => 75000,
            'Cek Plagiarisme' => 35000,
        ];

        return view('admin.orders.create', compact('services'));
    }

    /**
     * Store new order
     */
    public function store(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'service_name' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $order = new Order();
            $order->order_number = 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);
            $order->customer_name = $request->customer_name;
            $order->customer_phone = $request->customer_phone;
            $order->customer_email = $request->customer_email;
            $order->service_name = $request->service_name;
            $order->price = $request->price;
            $order->total_amount = $request->price;
            $order->status = 'pending';
            $order->payment_status = 'unpaid';
            $order->assigned_to = Session::get('admin_name', 'Admin');

            $order->save();

            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show order details
     */
    public function show($id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $order = Order::findOrFail($id);
            return view('admin.orders.show', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak ditemukan!');
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $order = Order::findOrFail($id);
            return view('admin.orders.edit', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak ditemukan!');
        }
    }

    /**
     * Update order
     */
    public function update(Request $request, $id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'service_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        try {
            $order = Order::findOrFail($id);
            $order->customer_name = $request->customer_name;
            $order->customer_phone = $request->customer_phone;
            $order->customer_email = $request->customer_email;
            $order->service_name = $request->service_name;
            $order->price = $request->price;
            $order->total_amount = $request->price;
            $order->status = $request->status;
            $order->payment_status = $request->payment_status;

            $order->save();

            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil diupdate!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate pesanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete order
     */
    public function destroy($id)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $order = Order::findOrFail($id);
            $orderNumber = $order->order_number;
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
     * Update status via AJAX
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $order = Order::findOrFail($id);
            $order->status = $request->status;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal update status: ' . $e->getMessage()], 500);
        }
    }
}
