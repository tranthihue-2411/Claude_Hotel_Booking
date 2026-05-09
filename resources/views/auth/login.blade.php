@extends('layouts.app')

@section('title', 'Đăng nhập - HotelHub')

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
                        <i class="fas fa-hotel text-white text-xl"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white">Đăng nhập</h1>
                    <p class="text-blue-200 text-sm mt-1">Chào mừng bạn trở lại HotelHub</p>
                </div>

                <!-- Form -->
                <div class="px-8 py-7">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Remember -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 rounded accent-blue-600">
                                <span class="text-sm text-slate-500">Ghi nhớ đăng nhập</span>
                            </label>
                            <a href="{{ route('password.request') }}" 
                                class="text-sm text-blue-600 hover:underline">
                                    Quên mật khẩu?
                            </a>
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-slate-100"></div>
                        <span class="text-xs text-slate-400">hoặc</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>

                    <!-- Register Link -->
                    <p class="text-center text-sm text-slate-500">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                            Đăng ký ngay
                        </a>
                    </p>

                    <!-- Demo Accounts -->
                    <div class="mt-5 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
                            Tài khoản demo
                        </p>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-shield text-blue-600 text-xs"></i>
                                </div>
                                <span>Admin: <span class="font-medium text-slate-700">admin@hotel.com</span> / password</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <div class="w-5 h-5 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-emerald-600 text-xs"></i>
                                </div>
                                <span>User: <span class="font-medium text-slate-700">usera@hotel.com</span> / password</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection