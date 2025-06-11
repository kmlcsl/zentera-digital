<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Zentera Digital</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 2px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.5);
        }

        /* Smooth transitions */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .overlay-transition {
            transition: opacity 0.3s ease-in-out;
        }

        /* Mobile sidebar positioning - PERBAIKAN DI SINI */
        .sidebar-mobile {
            transform: translateX(-100%);
        }

        .sidebar-mobile.open {
            transform: translateX(0);
        }

        /* Desktop - TAMBAH INI */
        @media (min-width: 1024px) {
            .sidebar-mobile {
                transform: translateX(0) !important;
            }
        }

        /* Backdrop blur effect */
        .backdrop-blur-custom {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Overlay -->
        <div id="mobileOverlay"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-custom z-40 lg:hidden opacity-0 pointer-events-none overlay-transition">
        </div>

        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed lg:relative w-64 bg-white shadow-lg flex flex-col z-50 h-full sidebar-transition sidebar-mobile lg:transform-none">

            <!-- Mobile Close Button -->
            <div class="lg:hidden flex justify-end p-4">
                <button id="closeSidebar"
                    class="text-gray-500 hover:text-gray-700 transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-gray-200 lg:mt-0 -mt-16">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-2">
                        <i class="fas fa-code text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-bold text-gray-800">Admin Panel</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 sidebar-scrollbar overflow-y-auto">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : '' }}"
                            onclick="closeMobileSidebar()">
                            <i class="fas fa-chart-line mr-3 w-5"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.products.index') ? 'bg-blue-50 text-blue-700' : '' }}"
                            onclick="closeMobileSidebar()">
                            <i class="fas fa-box mr-3 w-5"></i>
                            <span>Produk & Layanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.orders.index') ? 'bg-blue-50 text-blue-700' : '' }}"
                            onclick="closeMobileSidebar()">
                            <i class="fas fa-shopping-cart mr-3 w-5"></i>
                            <span>Pesanan</span>
                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">8</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 {{ request()->routeIs('admin.settings.index') ? 'bg-blue-50 text-blue-700' : '' }}"
                            onclick="closeMobileSidebar()">
                            <i class="fas fa-cog mr-3 w-5"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-6"></div>

                <!-- Quick Links -->
                <div class="space-y-2">
                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Quick Links</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('home') }}" target="_blank"
                                class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-external-link-alt mr-3 text-sm w-5"></i>
                                <span class="text-sm">Lihat Website</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/{{ config('app.whatsapp_number', '6281330053572') }}" target="_blank"
                                class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                <i class="fab fa-whatsapp mr-3 text-sm w-5"></i>
                                <span class="text-sm">WhatsApp</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- User Info & Logout -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center min-w-0 flex-1">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-700 truncate">
                                {{ session('admin_name', session('admin_username', 'Admin')) }}</p>
                            <p class="text-xs text-gray-500">{{ session('admin_role', 'Administrator') }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline ml-2">
                        @csrf
                        <button type="submit"
                            class="text-gray-500 hover:text-red-600 transition-colors duration-200 flex-shrink-0"
                            title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile Menu Button -->
                            <button id="mobileMenuBtn"
                                class="lg:hidden text-gray-500 hover:text-gray-700 transition-colors duration-200 mr-4 p-2 rounded-full hover:bg-gray-100">
                                <i class="fas fa-bars text-xl"></i>
                            </button>

                            <div>
                                <h1 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h1>
                                <p class="text-sm text-gray-500 mt-1 hidden sm:block">
                                    {{ session('admin_name', 'Selamat datang di Admin Panel') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button
                                    class="text-gray-500 hover:text-gray-700 relative transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                                    <i class="fas fa-bell text-lg"></i>
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 rounded-full flex items-center justify-center">3</span>
                                </button>
                            </div>

                            <!-- Current Time -->
                            <div class="text-xs sm:text-sm text-gray-600 hidden sm:block">
                                <span id="currentTime"></span>
                            </div>

                            <!-- Mobile User Menu -->
                            <div class="lg:hidden">
                                <button
                                    class="flex items-center text-gray-500 hover:text-gray-700 transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span class="font-medium">Ada beberapa error:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // PINDAHKAN FUNCTION KE GLOBAL SCOPE
        function openMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            if (sidebar && mobileOverlay) {
                sidebar.classList.add('open');
                mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
                mobileOverlay.classList.add('opacity-100');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            if (sidebar && mobileOverlay) {
                sidebar.classList.remove('open');
                mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
                mobileOverlay.classList.remove('opacity-100');
                document.body.style.overflow = '';
            }
        }

        // EVENT LISTENERS
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const closeSidebar = document.getElementById('closeSidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            // Mobile menu button
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openMobileSidebar();
                });
            }

            // Close button (X)
            if (closeSidebar) {
                closeSidebar.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeMobileSidebar();
                });
            }

            // Overlay click
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeMobileSidebar();
                });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeMobileSidebar();
                    document.body.style.overflow = '';
                }
            });

            // ESC key to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeMobileSidebar();
                }
            });

            // Update current time
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleString('id-ID', {
                    weekday: 'short',
                    day: 'numeric',
                    month: 'short',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const currentTimeElement = document.getElementById('currentTime');
                if (currentTimeElement) {
                    currentTimeElement.textContent = timeString + ' WIB';
                }
            }

            // Update time every minute
            updateTime();
            setInterval(updateTime, 60000);

            // Auto-hide success/error messages
            setTimeout(function() {
                const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 5000);

            // Confirm logout
            const logoutForm = document.querySelector('form[action="{{ route('admin.logout') }}"]');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    if (!confirm('Apakah Anda yakin ingin logout?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
