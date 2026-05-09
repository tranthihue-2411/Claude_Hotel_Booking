<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HotelHub - Đặt Phòng Khách Sạn')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-link { position: relative; }
        .nav-link::after { content:''; position:absolute; bottom:-4px; left:0; width:0; height:2px; background:#2563eb; transition:width 0.25s; border-radius:2px; }
        .nav-link:hover::after { width:100%; }
        .dropdown-menu { display:none; }
        .dropdown-menu.open { display:block; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800">

   <!-- Navbar -->
<nav class="bg-white border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

        <!-- Logo BÊN TRÁI -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-hotel text-white text-sm"></i>
            </div>
            <span style="font-weight:700; color:#1e293b; font-size:18px;">
                Hotel<span style="color:#2563eb;">Hub</span>
            </span>
        </a>

        <!-- TẤT CẢ BÊN PHẢI -->
        <div class="flex items-center gap-6">

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}"
                    class="nav-link text-slate-500 hover:text-blue-600 text-sm font-medium transition-colors">
                    Trang chủ
                </a>
                <a href="{{ route('hotels.search') }}"
                    class="nav-link text-slate-500 hover:text-blue-600 text-sm font-medium transition-colors">
                    Khách sạn
                </a>
                @auth
                <a href="{{ route('bookings.index') }}"
                    class="nav-link text-slate-500 hover:text-blue-600 text-sm font-medium transition-colors">
                    Đặt phòng của tôi
                </a>
                @endauth
            </div>

            <!-- Auth -->
            @guest
                <a href="{{ route('login') }}"
                    class="text-slate-500 hover:text-blue-600 text-sm font-medium transition-colors">
                    Đăng nhập
                </a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    Đăng ký
                </a>
            @else
                @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}"
                    class="text-slate-500 hover:text-blue-600 text-sm font-medium transition-colors">
                    <i class="fas fa-tachometer-alt mr-1 text-xs"></i>Admin
                </a>
                @endif

                <!-- User Dropdown — CHỈ CÓ HỒ SƠ + ĐĂNG XUẤT -->
                <div class="relative" id="userDropdown">
                    <button onclick="toggleDropdown()"
                        class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 px-3 py-2 rounded-xl transition-colors">
                        <div class="w-7 h-7 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-slate-700 max-w-28 truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <i class="fas fa-chevron-down text-xs text-slate-400" id="chevronIcon"
                            style="transition: transform 0.2s ease;"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="dropdownMenu"
                        class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <i class="fas fa-user text-slate-300 w-4 text-center"></i>
                                Tài khoản
                            </a>
                        </div>
                        <div class="border-t border-slate-100 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-4 text-center"></i>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>

    </div>
</nav>
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-6 mt-4">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle text-emerald-500"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-6 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <main>@yield('content')</main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white mt-20 py-10">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-7 h-7 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hotel text-white text-xs"></i>
                </div>
                <span class="font-bold text-lg">Hotel<span class="text-blue-400">Hub</span></span>
            </div>
            <p class="text-slate-400 text-sm">© {{ date('Y') }} HotelHub — Hệ thống đặt phòng khách sạn trực tuyến.</p>
        </div>
    </footer>

    @stack('scripts')

    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            const icon = document.getElementById('chevronIcon');
            menu.classList.toggle('open');
            icon.style.transform = menu.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
            icon.style.transition = 'transform 0.2s ease';
        }

        // Đóng dropdown khi click ra ngoài
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                document.getElementById('dropdownMenu').classList.remove('open');
                document.getElementById('chevronIcon').style.transform = 'rotate(0deg)';
            }
        });
    </script>
</body>
</html>