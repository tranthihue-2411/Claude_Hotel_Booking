@extends('layouts.app')

@section('title', 'Đặt phòng của tôi - HotelHub')

@push('styles')
<style>
    .booking-card {
        transition: all 0.25s ease;
    }
    .booking-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(37,99,235,0.09);
    }
</style>
@endpush

@section('content')

<!-- Page Header -->
<div class="bg-white border-b border-slate-100">
    <div class="max-w-5xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-600 text-xs font-bold uppercase tracking-widest mb-1">
                    <i class="fas fa-calendar-alt mr-1"></i> Lịch sử
                </p>
                <h1 class="text-2xl font-bold text-slate-800">Đặt phòng của tôi</h1>
            </div>
            <a href="{{ route('hotels.search') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                <i class="fas fa-search"></i> Tìm khách sạn mới
            </a>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-6 py-8">

    @forelse($bookings as $booking)
    <div class="booking-card bg-white rounded-2xl border border-slate-100 overflow-hidden mb-5 shadow-sm">
        <div class="flex">
            <!-- Hotel Image -->
            <div class="w-48 flex-shrink-0 overflow-hidden">
                <img src="{{ $booking->hotel->main_image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop' }}"
                    alt="{{ $booking->hotel->name }}"
                    class="w-full h-full object-cover" style="min-height: 160px;">
            </div>

            <!-- Content -->
            <div class="flex-1 p-5">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">{{ $booking->hotel->name }}</h3>
                        <p class="text-slate-400 text-xs mt-0.5 flex items-center gap-1">
                            <i class="fas fa-bed text-slate-300"></i>
                            {{ $booking->room->name }}
                        </p>
                        <p class="text-slate-400 text-xs mt-0.5 flex items-center gap-1">
                            <i class="fas fa-hashtag text-slate-300"></i>
                            {{ $booking->booking_reference }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold flex-shrink-0
                        {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-500 border border-red-100' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-3 gap-3 my-4 p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div>
                        <p class="text-slate-400 text-xs mb-0.5">Nhận phòng</p>
                        <p class="font-semibold text-slate-700 text-sm">{{ $booking->check_in_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-slate-400 text-xs mb-0.5">Số đêm</p>
                        <p class="font-semibold text-slate-700 text-sm">{{ $booking->number_of_nights }} đêm</p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-400 text-xs mb-0.5">Trả phòng</p>
                        <p class="font-semibold text-slate-700 text-sm">{{ $booking->check_out_date->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-slate-400 text-xs">Tổng tiền</span>
                        <span class="text-blue-600 font-bold text-xl ml-2">${{ number_format($booking->total_amount) }}</span>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('bookings.show', $booking) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition-colors flex items-center gap-1.5">
                            <i class="fas fa-eye"></i> Chi tiết
                        </a>
                        @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn hủy đặt phòng này?')">
                            @csrf
                            <button type="submit"
                                class="border border-red-200 text-red-500 hover:bg-red-50 px-4 py-2 rounded-xl text-xs font-semibold transition-colors flex items-center gap-1.5">
                                <i class="fas fa-times"></i> Hủy
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center shadow-sm">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-calendar-times text-slate-300 text-3xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-600 mb-2">Chưa có đặt phòng nào</h3>
        <p class="text-slate-400 text-sm mb-6">Hãy tìm kiếm và đặt phòng khách sạn yêu thích</p>
        <a href="{{ route('hotels.search') }}"
            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-colors">
            <i class="fas fa-search"></i> Tìm khách sạn ngay
        </a>
    </div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-4">{{ $bookings->links() }}</div>
</div>

@endsection