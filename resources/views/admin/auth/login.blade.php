<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Zentera Digital</title>

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

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-32 w-24 h-24 bg-white/5 rounded-full animate-float"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-32 left-1/3 w-20 h-20 bg-white/10 rounded-full animate-float"
            style="animation-delay: 4s;"></div>
        <div class="absolute top-1/2 right-20 w-16 h-16 bg-white/5 rounded-full animate-float"
            style="animation-delay: 3s;"></div>
    </div>

    <div class="w-full max-w-md px-6 relative z-10">
        <!-- Login Card -->
        <div class="glass-effect rounded-2xl border border-white/30 p-8 shadow-2xl">
            <!-- Logo & Title -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-shield text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Admin Panel</h1>
                <p class="text-gray-200">Zentera Digital</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-300 mr-2"></i>
                        <span class="text-red-300 text-sm">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-2"></i>
                        <span class="text-green-300 text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent transition-all duration-300"
                        placeholder="Masukkan email admin" value="{{ old('email') }}">
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-gray-200 text-sm font-medium mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-lg text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent transition-all duration-300"
                            placeholder="Masukkan password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300 hover:text-white transition-colors duration-300">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="h-4 w-4 text-white bg-white/10 border-white/30 rounded focus:ring-white/50">
                    <label for="remember" class="ml-2 block text-sm text-gray-200">
                        Ingat saya
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-white text-purple-600 py-3 px-6 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk Admin Panel
                </button>
            </form>

            <!-- Login Info -->
            {{-- <div class="mt-6 p-4 bg-white/10 rounded-lg border border-white/20">
                <h4 class="text-white font-medium mb-2">
                    <i class="fas fa-info-circle mr-2"></i>Info Login:
                </h4>
                <div class="text-gray-200 text-sm space-y-1">
                    <p><strong>Email:</strong> muhammadkamilcsl19@gmail.com</p>
                    <p><strong>Password:</strong> admin190303</p>
                </div>
            </div> --}}

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}"
                    class="text-gray-300 hover:text-white text-sm transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Website
                </a>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="text-center mt-6 text-gray-300 text-xs">
            <p>
                <i class="fas fa-shield-alt mr-1"></i>
                Area terbatas hanya untuk administrator
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto focus pada email field
        document.querySelector('input[name="email"]').focus();

        // Keyboard shortcut untuk login (Ctrl + Enter)
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                document.querySelector('form').submit();
            }
        });

        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-red-500\\/20, .bg-green-500\\/20');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>

</html>
