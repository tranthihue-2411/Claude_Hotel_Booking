@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa người dùng - Admin')
@section('page-title', 'Chỉnh sửa người dùng')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1.5">
        <i class="fas fa-arrow-left text-xs"></i> Quay lại danh sách
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between">
            <h2 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fas fa-user text-blue-500 text-sm"></i>
                Chỉnh sửa: {{ $user->name }}
            </h2>
            @if($user->is_locked)
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-500 border border-red-100">
                <i class="fas fa-lock text-xs mr-1"></i> Đã khóa
            </span>
            @else
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                <i class="fas fa-check-circle text-xs mr-1"></i> Hoạt động
            </span>
            @endif
        </div>

        <!-- Avatar -->
        <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-slate-800">{{ $user->name }}</p>
                <p class="text-slate-400 text-sm">{{ $user->email }}</p>
                <p class="text-slate-300 text-xs mt-0.5">Đăng ký: {{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Form -->
        <div class="p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                        Họ và tên
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                        @error('name') border-red-300 @enderror">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500
                        @error('email') border-red-300 @enderror">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t border-slate-50">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>

        <!-- Khóa/Mở khóa -->
        <div class="px-6 pb-6">
            <div class="bg-slate-50 rounded-xl border border-slate-100 p-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-slate-700 text-sm">
                        {{ $user->is_locked ? 'Tài khoản đang bị khóa' : 'Khóa tài khoản' }}
                    </p>
                    <p class="text-slate-400 text-xs mt-0.5">
                        {{ $user->is_locked ? 'Mở khóa để cho phép người dùng đăng nhập lại' : 'Người dùng sẽ không thể đăng nhập khi bị khóa' }}
                    </p>
                </div>
                <form action="{{ route('admin.users.toggle-lock', $user) }}" method="POST"
                    onsubmit="return confirm('{{ $user->is_locked ? 'Mở khóa' : 'Khóa' }} tài khoản này?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2
                        {{ $user->is_locked ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-red-500 hover:bg-red-600 text-white' }}">
                        <i class="fas {{ $user->is_locked ? 'fa-unlock' : 'fa-lock' }}"></i>
                        {{ $user->is_locked ? 'Mở khóa' : 'Khóa tài khoản' }}
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection