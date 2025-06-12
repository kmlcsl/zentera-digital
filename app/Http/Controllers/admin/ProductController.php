<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display products list
     */
    public function index()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            // Ambil products dari database sebagai OBJECT (bukan array)
            $products = Product::orderBy('sort_order', 'asc')
                ->orderBy('name', 'asc')
                ->get()
                ->map(function ($product) {
                    // Convert semua array fields ke string untuk view
                    foreach (['features', 'requirements', 'tags'] as $field) {
                        if (isset($product->$field) && is_array($product->$field)) {
                            $product->$field = implode(', ', $product->$field);
                        }
                    }
                    return $product;
                });

            // Stats sederhana
            $stats = [
                'total_products' => $products->count(),
                'active_products' => $products->where('is_active', true)->count(),
                'inactive_products' => $products->where('is_active', false)->count(),
            ];

            return view('admin.products.index', compact('products', 'stats'));
        } catch (\Exception $e) {
            // Fallback data sebagai COLLECTION, bukan array
            $products = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Website Portfolio',
                    'category' => 'Website',
                    'price' => 500000,
                    'is_active' => true,
                    'sort_order' => 1
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Website E-Commerce',
                    'category' => 'Website',
                    'price' => 1500000,
                    'is_active' => true,
                    'sort_order' => 2
                ]
            ]);

            $stats = ['total_products' => 2, 'active_products' => 2, 'inactive_products' => 0];

            return view('admin.products.index', compact('products', 'stats'))
                ->with('warning', 'Menggunakan data fallback');
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

        return view('admin.products.create');
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'nullable|numeric|min:0',
        ]);

        try {
            $product = new Product();
            $product->name = $request->name;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->price = $request->price ?? 0;
            $product->original_price = $request->original_price;
            $product->features = $request->features ? explode("\n", trim($request->features)) : [];
            $product->icon = $request->icon ?? 'fas fa-star';
            $product->color = $request->color ?? 'blue';
            $product->whatsapp_text = $request->whatsapp_text ?? "Halo, saya tertarik dengan layanan {$request->name}";
            $product->show_price = $request->has('show_price');
            $product->price_label = $request->price_label ?? 'Rp';
            $product->service_note = $request->service_note;
            $product->is_active = $request->has('is_active');
            $product->sort_order = $request->sort_order ?? 0;
            $product->save();

            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah produk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show product details
     */
    public function show($id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            $product = Product::findOrFail($id);
            return view('admin.products.show', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Produk tidak ditemukan!');
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
            $product = Product::findOrFail($id);
            return view('admin.products.edit', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Produk tidak ditemukan!');
        }
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'nullable|numeric|min:0',
        ]);

        try {
            $product = Product::findOrFail($id);

            // DEBUG: Cek input features
            Log::info('Features Input:', [
                'raw' => $request->features,
                'trimmed' => trim($request->features ?? ''),
                'empty_check' => empty(trim($request->features ?? ''))
            ]);

            // Processing features dengan benar
            $features = null;
            if ($request->features && trim($request->features) !== '') {
                $featuresArray = array_filter(
                    array_map('trim', explode("\n", trim($request->features))),
                    function ($item) {
                        return !empty(trim($item));
                    }
                );
                $features = !empty($featuresArray) ? $featuresArray : null;

                // DEBUG: Cek hasil processing
                Log::info('Features Processed:', [
                    'array' => $featuresArray,
                    'final' => $features
                ]);
            }

            $data = [
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'price' => $request->price ?? 0,
                'original_price' => $request->original_price,
                'features' => $features,
                'icon' => $request->icon ?? 'fas fa-star',
                'color' => $request->color ?? 'blue',
                'whatsapp_text' => $request->whatsapp_text ?? "Halo, saya tertarik dengan layanan {$request->name}",
                'show_price' => $request->has('show_price'),
                'price_label' => $request->price_label ?? 'Rp',
                'service_note' => $request->service_note,
                'is_active' => $request->has('is_active'),
                'is_featured' => $request->has('is_featured'),
                'sort_order' => $request->sort_order ?? 0,
            ];

            // DEBUG: Cek data sebelum update
            Log::info('Update Data:', $data);

            $product->update($data);

            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
        } catch (\Exception $e) {
            Log::error('Update Error:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal mengupdate produk: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete product
     */
    public function destroy($id)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus produk: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Toggle product visibility
     */
    public function toggleVisibility(Request $request)
    {
        if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $product = Product::findOrFail($request->id);
            $product->is_active = !$product->is_active;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate!',
                'new_status' => $product->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal update status: ' . $e->getMessage()], 500);
        }
    }
}
