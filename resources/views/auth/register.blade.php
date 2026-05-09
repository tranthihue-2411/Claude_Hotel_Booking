@extends('layouts.app')

@section('title', 'Đăng ký - HotelHub')

@push('styles')
<style>
    .auth-bg {
        background: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1600&h=900&fit=crop&q=80') center/cover no-repeat;
        min-height: 100vh;
    }
    .auth-overlay {
        background: rgba(8, 20, 60, 0.70);
        min-height: 100vh;
    }
    .input-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        color: #1e293b;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
    }
    .input-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }
</style>
@endpush

@section('content')
<div class="auth-bg">
    <div class="auth-overlay flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

                <!-- Header -->
                <div class="bg-blue-600 px-8 py-7 text-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white">Tạo tài khoản</h1>
                    <p class="text-blue-200 text-sm mt-1">Tham gia HotelHub ngay hôm nay</p>
                </div>

                <!-- Form -->
                <div class="px-8 py-7">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Họ và tên
                            </label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="input-field pl-9"
                                    placeholder="Nguyễn Văn A">
                            </div>
                            @error('name')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Email
                            </label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="input-field pl-9"
                                    placeholder="example@email.com">
                            </div>
                            @error('email')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Mật khẩu
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="password" name="password"
                                    class="input-field pl-9"
                                    placeholder="Tối thiểu 8 ký tự">
                            </div>
                            @error('password')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                                Xác nhận mật khẩu
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3 text-slate-300 text-sm"></i>
                                <input type="password" name="password_confirmation"
                                    class="input-field pl-9"
                                    placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-slate-100"></div>
                        <span class="text-xs text-slate-400">hoặc</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-slate-500">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                            Đăng nhập
                        </a>
                    </p>

                    <!-- Benefits -->
                    <div class="mt-5 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
                            Lợi ích khi đăng ký
                        </p>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                                <span>Đặt phòng nhanh chóng, dễ dàng</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                                <span>Quản lý đặt phòng mọi lúc mọi nơi</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                                <span>Nhận thông báo xác nhận tức thì</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection