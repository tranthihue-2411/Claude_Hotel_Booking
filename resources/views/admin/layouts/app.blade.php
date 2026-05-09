<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - HotelHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.08);
        }
        .sidebar-link.active {
            background: #2563eb;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100" style="display:flex; min-height:100vh;">

<div style="display:flex; width:100%; min-height:100vh;">

    <!-- ═══ SIDEBAR ═══ -->
    <aside style="width:240px; min-width:240px; background:#0f172a; display:flex; flex-direction:column;">

        <!-- Logo -->
        <div style="padding:24px 20px; border-bottom:1px solid rgba(255,255,255,0.08);">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div style="width:32px; height:32px; background:#2563eb; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-hotel text-white text-sm"></i>
                </div>
                <span style="font-weight:700; font-size:16px; color:#fff;">
                    Hotel<span style="color:#60a5fa;">Hub</span>
                </span>
                <span style="font-size:10px; background:#2563eb; color:#fff; padding:2px 6px; border-radius:4px; margin-left:2px; font-weight:600;">
                    ADMIN
                </span>
            </a>
        </div>

        <!-- Nav -->
        <nav style="padding:16px 12px; flex:1;">
            <p style="font-size:10px; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:1px; padding:0 8px; margin-bottom:8px;">
                Quản lý
            </p>

            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:#94a3b8; font-size:14px; font-weight:500; text-decoration:none; margin-bottom:4px;">
                <i class="fas fa-tachometer-alt" style="width:16px; text-align:center;"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.hotels.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.hotels.*') ? 'active' : '' }}"
                style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:#94a3b8; font-size:14px; font-weight:500; text-decoration:none; margin-bottom:4px;">
                <i class="fas fa-hotel" style="width:16px; text-align:center;"></i>
                Quản lý khách sạn
            </a>

            <a href="{{ route('admin.bookings.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
                style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:#94a3b8; font-size:14px; font-weight:500; text-decoration:none; margin-bottom:4px;">
                <i class="fas fa-calendar-alt" style="width:16px; text-align:center;"></i>
                Quản lý đặt phòng
            </a>

            <div style="border-top:1px solid rgba(255,255,255,0.08); margin:16px 0;"></div>

            <a href="{{ route('home') }}"
                class="sidebar-link"
                style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:#94a3b8; font-size:14px; font-weight:500; text-decoration:none; margin-bottom:4px;">
                <i class="fas fa-globe" style="width:16px; text-align:center;"></i>
                Về trang chủ
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="sidebar-link"
                    style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:#f87171; font-size:14px; font-weight:500; width:100%; background:none; border:none; cursor:pointer; text-align:left; margin-bottom:4px;">
                    <i class="fas fa-sign-out-alt" style="width:16px; text-align:center;"></i>
                    Đăng xuất
                </button>
            </form>
        </nav>

        <!-- User Info -->
        <div style="padding:16px; border-top:1px solid rgba(255,255,255,0.08);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:#2563eb; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:13px; font-weight:700; flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div style="min-width:0;">
                    <p style="font-size:13px; font-weight:600; color:#f1f5f9; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p>
                    <p style="font-size:11px; color:#64748b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ auth()->user()->email ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <!-- ═══ MAIN CONTENT ═══ -->
    <div style="flex:1; display:flex; flex-direction:column; min-width:0;">

        <!-- Top Bar -->
        <header style="background:#fff; border-bottom:1px solid #f1f5f9; padding:0 24px; height:60px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <h1 style="font-size:18px; font-weight:700; color:#1e293b;">
                @yield('page-title', 'Dashboard')
            </h1>
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:8px; height:8px; background:#22c55e; border-radius:50%;"></div>
                <span style="font-size:13px; color:#64748b; font-weight:500;">Hệ thống đang hoạt động</span>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
        <div style="margin:16px 24px 0;">
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; padding:12px 16px; border-radius:12px; display:flex; align-items:center; gap:8px; font-size:14px;">
                <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div style="margin:16px 24px 0;">
            <div style="background:#fef2f2; border:1px solid #fecaca; color:#dc2626; padding:12px 16px; border-radius:12px; display:flex; align-items:center; gap:8px; font-size:14px;">
                <i class="fas fa-exclamation-circle" style="color:#ef4444;"></i>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Page Content -->
        <main style="flex:1; padding:24px; overflow-y:auto;">
            @yield('content')
        </main>
    </div>

</div>

@stack('scripts')
</body>
</html>