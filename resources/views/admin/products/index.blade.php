@extends('admin.layouts.app')

@section('title', 'Kelola Produk')
@section('page_title', 'Produk & Layanan')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Produk & Layanan</h1>
                <p class="text-gray-600 mt-1">Atur harga, status, dan informasi produk</p>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-box text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($products) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-eye text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Produk Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ collect($products)->where('status', 'active')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-shopping-cart text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ collect($products)->sum('orders') }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-star text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Terlaris</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ collect($products)->sortByDesc('orders')->first()['name'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Daftar Produk</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $product['name'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($product['category'] == 'Website') bg-blue-100 text-blue-800
                                @elseif($product['category'] == 'Wedding') bg-pink-100 text-pink-800
                                @elseif($product['category'] == 'Software') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                        {{ $product['category'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if ($product['price'])
                                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                                            @if ($product['original_price'])
                                                <span class="text-xs text-gray-500 line-through ml-1">
                                                    Rp {{ number_format($product['original_price'], 0, ',', '.') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Konsultasi</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $product['orders'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($product['status'] == 'active')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button
                                            onclick="window.location.href='{{ route('admin.products.edit', $product->id) }}'"
                                            class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="toggleStatus({{ $product->id }})"
                                            class="text-green-600 hover:text-green-900" title="Toggle Status">
                                            <i class="fas fa-toggle-{{ $product->is_active ? 'on' : 'off' }}"></i>
                                        </button>
                                        <button onclick="deleteProduct({{ $product->id }})"
                                            class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Harga Massal</h3>
                <div class="space-y-4">
                    <select class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option>Pilih Kategori</option>
                        <option>Website</option>
                        <option>Wedding</option>
                        <option>Software</option>
                        <option>Document</option>
                    </select>
                    <div class="flex space-x-2">
                        <input type="number" placeholder="Diskon %"
                            class="flex-1 border border-gray-300 rounded-md px-3 py-2">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Export Data</h3>
                <div class="space-y-2">
                    <button class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">
                        <i class="fas fa-file-excel mr-2"></i>Export ke Excel
                    </button>
                    <button class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">
                        <i class="fas fa-file-pdf mr-2"></i>Export ke PDF
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Cepat</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Produk Terlaris:</span>
                        <span
                            class="font-medium">{{ collect($products)->sortByDesc('orders')->first()['name'] ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Rata-rata Harga:</span>
                        <span class="font-medium">Rp
                            {{ number_format(collect($products)->where('price', '>', 0)->avg('price'), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Pendapatan:</span>
                        <span class="font-medium text-green-600">Rp
                            {{ number_format(collect($products)->sum(function ($p) {return $p['price'] * $p['orders'];}),0,',','.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleStatus(id) {
            if (confirm('Ubah status produk?')) {
                fetch(`/admin/products/toggle-visibility`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                }).then(() => location.reload());
            }
        }

        function deleteProduct(id) {
            if (confirm('Hapus produk ini?')) {
                fetch(`/admin/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(() => location.reload());
            }
        }
    </script>
@endpush
