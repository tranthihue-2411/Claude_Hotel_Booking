@extends('admin.layouts.app')

@section('title', $hotel->name . ' - Admin')
@section('page-title', 'Chi tiết khách sạn')

@section('content')

<div class="mb-4 flex items-center justify-between">
    <a href="{{ route('admin.hotels.index') }}" class="text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1.5">
        <i class="fas fa-arrow-left text-xs"></i> Quay lại danh sách
    </a>
    <div class="flex gap-2">
        <a href="{{ route('admin.hotels.edit', $hotel) }}"
            class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
            <i class="fas fa-edit"></i> Chỉnh sửa
        </a>
        <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST"
            onsubmit="return confirm('Bạn có chắc muốn xóa khách sạn này?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                <i class="fas fa-trash"></i> Xóa
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Cột trái -->
    <div class="lg:col-span-2 space-y-5">

        <!-- Hotel Image & Info -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="h-56 overflow-hidden">
                <img src="{{ $hotel->main_image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&h=400&fit=crop' }}"
                    alt="{{ $hotel->name }}"
                    class="w-full h-full object-cover">
            </div>
            <div class="p-6">
                <div class="flex items-start justify-between mb-2">
                    <h2 class="text-xl font-bold text-slate-800">{{ $hotel->name }}</h2>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                        {{ $hotel->is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-500 border border-red-100' }}">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        {{ $hotel->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                    </span>
                </div>
                <p class="text-slate-400 text-sm flex items-center gap-1.5 mb-4">
                    <i class="fas fa-map-marker-alt text-blue-500 text-xs"></i>
                    {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->province }}
                </p>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $hotel->description }}</p>

                <!-- Contact -->
                <div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-slate-50">
                    @if($hotel->phone)
                    <div class="flex items-center gap-2 text-sm text-slate-500">
                        <i class="fas fa-phone text-slate-300"></i>{{ $hotel->phone }}
                    </div>
                    @endif
                    @if($hotel->email)
                    <div class="flex items-center gap-2 text-sm text-slate-500">
                        <i class="fas fa-envelope text-slate-300"></i>{{ $hotel->email }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Amenities -->
        @if($hotel->amenities->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-concierge-bell text-blue-500 text-sm"></i> Tiện nghi
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($hotel->amenities as $amenity)
                <span class="bg-blue-50 text-blue-700 border border-blue-100 text-xs px-3 py-1.5 rounded-xl font-medium">
                    {{ $amenity->icon }} {{ $amenity->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Rooms -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-bed text-blue-500 text-sm"></i>
                Danh sách phòng
                <span class="ml-auto bg-blue-50 text-blue-600 text-xs font-semibold px-2.5 py-1 rounded-lg border border-blue-100">
                    {{ $hotel->rooms->count() }} phòng
                </span>
            </h3>
            <div class="space-y-3">
                @forelse($hotel->rooms as $room)
                <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                    <div>
                        <p class="font-semibold text-slate-700 text-sm">{{ $room->name }}</p>
                        <p class="text-slate-400 text-xs mt-0.5">
                            {{ $room->bed_type }} • Tối đa {{ $room->max_guests }} khách
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-blue-600 text-sm">${{ number_format($room->price_per_night) }}/đêm</p>
                        <span class="text-xs {{ $room->is_active ? 'text-emerald-500' : 'text-red-400' }}">
                            <i class="fas fa-circle text-xs mr-0.5"></i>
                            {{ $room->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-slate-400 text-sm text-center py-4">Chưa có phòng nào</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Cột phải -->
    <div class="space-y-5">

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-blue-500 text-sm"></i> Thống kê
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 text-sm">Đánh giá</span>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-star text-amber-400 text-xs"></i>
                        <span class="font-bold text-slate-800">{{ number_format($hotel->rating, 1) }}</span>
                        <span class="text-slate-300 text-xs">({{ $hotel->review_count }})</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 text-sm">Tổng đặt phòng</span>
                    <span class="font-bold text-slate-800">{{ $hotel->bookings->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 text-sm">Số phòng</span>
                    <span class="font-bold text-slate-800">{{ $hotel->rooms->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 text-sm">Tổng đánh giá</span>
                    <span class="font-bold text-slate-800">{{ $hotel->reviews->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-blue-500 text-sm"></i> Đặt phòng gần đây
            </h3>
            <div class="space-y-3">
                @forelse($hotel->bookings->take(5) as $booking)
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('admin.bookings.show', $booking) }}"
                            class="text-blue-600 hover:text-blue-700 text-xs font-semibold">
                            {{ $booking->booking_reference }}
                        </a>
                        <p class="text-slate-400 text-xs">{{ $booking->guest_name }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-500' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                @empty
                <p class="text-slate-400 text-sm text-center py-2">Chưa có đặt phòng</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection