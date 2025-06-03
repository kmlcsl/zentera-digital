{{-- Tambahkan CSS ini di bagian atas file atau di app.css --}}
<style>
    .glass-effect {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.50), rgba(124, 58, 237, 0.50)) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }
</style>

<nav class="fixed w-full z-50 glass-effect border-b border-white/20">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-code text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold text-white">Zentera Digital</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                    class="text-white hover:text-blue-300 transition-colors duration-300 font-medium {{ request()->routeIs('home') ? 'text-blue-300' : '' }}">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="{{ route('products') }}"
                    class="text-white hover:text-blue-300 transition-colors duration-300 font-medium {{ request()->routeIs('products') ? 'text-blue-300' : '' }}">
                    <i class="fas fa-shopping-bag mr-2"></i>Products
                </a>

                <!-- Admin Login (Hidden Button) -->
                <a href="{{ route('admin.login') }}"
                    class="hidden text-white hover:text-red-300 transition-colors duration-300 font-medium"
                    id="adminLink">
                    <i class="fas fa-user-shield mr-2"></i>Admin
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden pb-4">
            <div class="flex flex-col space-y-4">
                <a href="{{ route('home') }}"
                    class="text-white hover:text-blue-300 transition-colors duration-300 font-medium">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="{{ route('products') }}"
                    class="text-white hover:text-blue-300 transition-colors duration-300 font-medium">
                    <i class="fas fa-shopping-bag mr-2"></i>Products
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('hidden');
    }

    // Secret admin access (triple click logo)
    let clickCount = 0;
    document.querySelector('.flex.items-center').addEventListener('click', function() {
        clickCount++;
        if (clickCount === 3) {
            document.getElementById('adminLink').classList.remove('hidden');
            clickCount = 0;
        }
        setTimeout(() => clickCount = 0, 2000);
    });
</script>
