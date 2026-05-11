@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng - Admin')
@section('page-title', 'Quản lý người dùng')

@section('content')

<!-- Filter Bar -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">Tìm kiếm</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-2.5 text-slate-300 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full border border-slate-200 rounded-xl pl-8 pr-4 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Tìm theo tên, email...">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">Trạng thái</label>
                <select name="status"
                    class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">Tất cả</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="locked" {{ request('status') == 'locked' ? 'selected' : '' }}>Đã khóa</option>
                </select>
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-5 py-2 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                <i class="fas fa-times"></i> Xóa lọc
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between">
        <p class="text-sm text-slate-400">
            Tổng cộng <span class="font-semibold text-slate-600">{{ $users->total() }}</span> người dùng
        </p>
    </div>

    <table class="w-full">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50">
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Người dùng</th>
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Email</th>
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Ngày đăng ký</th>
                <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                <th class="text-right px-6 py-3.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Thao tác</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($users as $user)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $user->name }}</p>
                            <p class="text-slate-400 text-xs mt-0.5">ID: {{ $user->id }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-600 text-sm">{{ $user->email }}</td>
                <td class="px-6 py-4 text-slate-500 text-sm">
                    {{ $user->created_at->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4">
                    @if($user->is_locked)
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-500 border border-red-100">
                        <i class="fas fa-lock text-xs mr-1"></i> Đã khóa
                    </span>
                    @else
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                        <i class="fas fa-check-circle text-xs mr-1"></i> Hoạt động
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <!-- Sửa -->
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="w-8 h-8 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-edit text-xs"></i>
                        </a>

                        <!-- Khóa/Mở khóa -->
                        <form action="{{ route('admin.users.toggle-lock', $user) }}" method="POST"
                            onsubmit="return confirm('{{ $user->is_locked ? 'Mở khóa' : 'Khóa' }} tài khoản này?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                                {{ $user->is_locked ? 'bg-emerald-50 hover:bg-emerald-100 text-emerald-600' : 'bg-red-50 hover:bg-red-100 text-red-500' }}">
                                <i class="fas {{ $user->is_locked ? 'fa-unlock' : 'fa-lock' }} text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-slate-300 text-2xl"></i>
                    </div>
                    <p class="text-slate-400 text-sm">Không có người dùng nào</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 border-t border-slate-50">
        {{ $users->links() }}
    </div>
</div>

@endsection