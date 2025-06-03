@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-1">Selamat datang di panel admin Zentera Digital</p>
            </div>
            <div class="text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ now()->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] ?? 0 }}</p>
                        <p class="text-sm text-blue-600 mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>+12% dari bulan lalu
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pendapatan Bulan Ini</p>
                        <p class="text-3xl font-bold text-gray-900">Rp
                            {{ number_format($stats['monthly_revenue'] ?? 0, 0, ',', '.') }}</p>
                        <p class="text-sm text-green-600 mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>+8% dari bulan lalu
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pesanan Pending</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] ?? 0 }}</p>
                        <p class="text-sm text-yellow-600 mt-1">
                            <i class="fas fa-clock mr-1"></i>Perlu ditindaklanjuti
                        </p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-hourglass-half text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pesanan Minggu Ini</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['weekly_orders'] ?? 0 }}</p>
                        <p class="text-sm text-purple-600 mt-1">
                            <i class="fas fa-chart-line mr-1"></i>Trend positif
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Pendapatan Bulanan</h2>
                    <div class="flex space-x-2">
                        <button class="text-sm text-gray-500 hover:text-gray-700">6 Bulan</button>
                        <button class="text-sm text-blue-600 font-medium">1 Tahun</button>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Orders Chart -->
            <div class="bg-white rounded
        <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Jumlah Pesanan</h2>
                    <div class="flex space-x-2">
                        <button class="text-sm text-gray-500 hover:text-gray-700">Minggu</button>
                        <button class="text-sm text-blue-600 font-medium">Bulan</button>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders and Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h2>
                    <a href="{{ route('admin.orders.index') }}"
                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm min-w-[600px]">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-medium text-gray-600">ID</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Customer</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Service</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Harga</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recent_orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $order['id'] }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $order['customer'] }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $order['service'] }}</td>
                                    <td class="py-3 px-4 text-gray-600">Rp
                                        {{ number_format($order['price'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4">
                                        @if ($order['status'] == 'Completed')
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                <i class="fas fa-check mr-1"></i>Selesai
                                            </span>
                                        @elseif($order['status'] == 'In Progress')
                                            <span
                                                class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                                <i class="fas fa-spinner mr-1"></i>Proses
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-3 px-4 text-center text-gray-600">Belum ada pesanan terbaru
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="space-y-4">
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                        <div class="bg-blue-500 p-2 rounded-lg mr-3">
                            <i class="fas fa-box text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Kelola Produk</p>
                            <p class="text-sm text-gray-600">Update harga & status</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                        <div class="bg-green-500 p-2 rounded-lg mr-3">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Kelola Pesanan</p>
                            <p class="text-sm text-gray-600">Update status order</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.settings.index') }}"
                        class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200">
                        <div class="bg-purple-500 p-2 rounded-lg mr-3">
                            <i class="fas fa-cog text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Pengaturan</p>
                            <p class="text-sm text-gray-600">Konfigurasi website</p>
                        </div>
                    </a>

                    <a href="https://wa.me/{{ config('app.whatsapp_number', '621383894808') }}" target="_blank"
                        class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                        <div class="bg-green-600 p-2 rounded-lg mr-3">
                            <i class="fab fa-whatsapp text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">WhatsApp Business</p>
                            <p class="text-sm text-gray-600">Chat dengan customer</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>

    <script>
        // Fallback data if chart data is not available
        const defaultChartData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            revenue: [0, 0, 0, 0, 0, 0],
            orders: [0, 0, 0, 0, 0, 0]
        };

        const chartData = {!! json_encode($monthly_chart_data ?? defaultChartData) !!};

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Pendapatan (Juta)',
                    data: chartData.revenue.map(val => val / 1000000),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: chartData.orders,
                    backgroundColor: 'rgba(147, 51, 234, 0.8)',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
