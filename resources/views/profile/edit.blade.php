@extends('layouts.app')

@section('title', 'Hồ sơ của tôi - HotelHub')

@section('content')

<!-- Page Header -->
<div class="bg-white border-b border-slate-100">
    <div class="max-w-4xl mx-auto px-6 py-6">
        <p class="text-blue-600 text-xs font-bold uppercase tracking-widest mb-1">
            <i class="fas fa-user mr-1"></i> Tài khoản
        </p>
        <h1 class="text-2xl font-bold text-slate-800">Hồ sơ của tôi</h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-6 py-8">

    @if(session('status'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2 mb-6">
        <i class="fas fa-check-circle text-emerald-500"></i>
        {{ session('status') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Sidebar -->
        <div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center">
                <!-- Avatar -->
                <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <span class="text-white text-3xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <h3 class="font-bold text-slate-800 text-lg">{{ $user->name }}</h3>
                <p class="text-slate-400 text-sm">{{ $user->email }}</p>

                @if($user->is_admin)
                <span class="inline-block mt-2 bg-blue-50 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full border border-blue-100">
                    <i class="fas fa-shield-alt mr-1"></i> Admin
                </span>
                @endif

                <div class="mt-5 pt-5 border-t border-slate-50 space-y-2">
                    <a href="{{ route('bookings.index') }}"
                        class="flex items-center gap-2 text-slate-500 hover:text-blue-600 text-sm font-medium transition-colors">
                        <i class="fas fa-calendar-alt text-slate-300 w-4"></i>
                        Đặt phòng của tôi
                    </a>
                    @if($user->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-2 text-slate-500 hover:text-blue-600 text-sm font-medium transition-colors">
                        <i class="fas fa-tachometer-alt text-slate-300 w-4"></i>
                        Admin Dashboard
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Profile Info -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-50">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-user text-blue-500 text-sm"></i>
                        Thông tin cá nhân
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Họ và tên
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full border-1.5 border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                    @error('name') border-red-300 @enderror">
                            </div>
                            @error('name')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Email
                            </label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                    @error('email') border-red-300 @enderror">
                            </div>
                            @error('email')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                            <i class="fas fa-save"></i> Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-50">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-lock text-blue-500 text-sm"></i>
                        Đổi mật khẩu
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Mật khẩu hiện tại
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="password" name="current_password"
                                    class="w-full border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                    @error('current_password') border-red-300 @enderror"
                                    placeholder="••••••••">
                            </div>
                            @error('current_password')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Mật khẩu mới
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="password" name="password"
                                    class="w-full border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                    @error('password') border-red-300 @enderror"
                                    placeholder="Tối thiểu 8 ký tự">
                            </div>
                            @error('password')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Xác nhận mật khẩu mới
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="password" name="password_confirmation"
                                    class="w-full border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Nhập lại mật khẩu mới">
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                            <i class="fas fa-key"></i> Đổi mật khẩu
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection