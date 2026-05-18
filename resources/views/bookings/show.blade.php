@extends('layouts.app')

@section('title', 'Chi tiết đặt phòng - HotelHub')

@section('content')

<!-- Page Header -->
<div class="bg-white border-b border-slate-100">
    <div class="max-w-4xl mx-auto px-6 py-5">
        <div class="flex items-center gap-2 text-sm text-slate-400 mb-1">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('bookings.index') }}" class="hover:text-blue-600 transition-colors">Đặt phòng của tôi</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-slate-600 font-medium">{{ $booking->booking_reference }}</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800">Chi tiết đặt phòng</h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-6 py-8">

    <!-- Success Banner -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check text-emerald-600"></i>
        </div>
        <div>
            <p class="font-semibold text-emerald-700">Đặt phòng thành công!</p>
            <p class="text-emerald-600 text-sm">Mã đặt phòng: <span class="font-bold">{{ $booking->booking_reference }}</span></p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Cột trái -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Booking Info -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-blue-500 text-sm"></i>
                        Thông tin đặt phòng
                    </h2>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-500 border border-red-100' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}">
                        <i class="fas fa-circle text-xs mr-1"></i>{{ ucfirst($booking->status) }}
                    </span>
                </div>

                <div class="p-6">
                    <!-- Hotel & Room -->
                    <div class="flex gap-4 mb-5 pb-5 border-b border-slate-50">
                        <img src="{{ $booking->hotel->main_image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=200&h=150&fit=crop' }}"
                            alt="{{ $booking->hotel->name }}"
                            class="w-24 h-18 rounded-xl object-cover flex-shrink-0" style="height:72px;">
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $booking->hotel->name }}</h3>
                            <p class="text-slate-400 text-sm mt-0.5">
                                <i class="fas fa-bed mr-1 text-slate-300"></i>{{ $booking->room->name }}
                            </p>
                            <p class="text-slate-400 text-xs mt-1">
                                <i class="fas fa-hashtag mr-1 text-slate-300"></i>{{ $booking->booking_reference }}
                            </p>
                        </div>
                    </div>

                    <!-- Dates Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-5 pb-5 border-b border-slate-50">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-slate-400 text-xs mb-1">
                                <i class="fas fa-sign-in-alt mr-1 text-blue-400"></i>Nhận phòng
                            </p>
                            <p class="font-bold text-slate-800">{{ $booking->check_in_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-slate-400 text-xs mb-1">
                                <i class="fas fa-sign-out-alt mr-1 text-blue-400"></i>Trả phòng
                            </p>
                            <p class="font-bold text-slate-800">{{ $booking->check_out_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-slate-400 text-xs mb-1">
                                <i class="fas fa-moon mr-1 text-blue-400"></i>Số đêm
                            </p>
                            <p class="font-bold text-slate-800">{{ $booking->number_of_nights }} đêm</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-slate-400 text-xs mb-1">
                                <i class="fas fa-user mr-1 text-blue-400"></i>Số khách
                            </p>
                            <p class="font-bold text-slate-800">{{ $booking->number_of_guests }} khách</p>
                        </div>
                    </div>

                    <!-- Guest Info -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-slate-400 text-xs mb-1">Tên khách</p>
                            <p class="font-semibold text-slate-700 text-sm">{{ $booking->guest_name }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-xs mb-1">Email</p>
                            <p class="font-semibold text-slate-700 text-sm">{{ $booking->guest_email }}</p>
                        </div>
                        @if($booking->guest_phone)
                        <div>
                            <p class="text-slate-400 text-xs mb-1">Điện thoại</p>
                            <p class="font-semibold text-slate-700 text-sm">{{ $booking->guest_phone }}</p>
                        </div>
                        @endif
                        @if($booking->special_requests)
                        <div class="col-span-2">
                            <p class="text-slate-400 text-xs mb-1">Yêu cầu đặc biệt</p>
                            <p class="font-semibold text-slate-700 text-sm">{{ $booking->special_requests }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <a href="{{ route('bookings.index') }}"
                    class="flex-1 text-center border border-slate-200 text-slate-600 hover:bg-slate-50 py-3 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-list"></i> Tất cả đặt phòng
                </a>
                {{-- THÊM NÚT NÀY --}}
                @if($booking->status === 'pending')
                    <a href="{{ route('payment.show', $booking) }}"
                    class="flex-1 bg-yellow-500 text-white py-3 rounded-lg text-center hover:bg-yellow-600 font-semibold">
                        💳 Tiếp tục thanh toán
                    </a>
                @endif
                @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="flex-1"
                    onsubmit="return confirm('Bạn có chắc muốn hủy đặt phòng này?')">
                    @csrf
                    <button type="submit"
                        class="w-full border border-red-200 text-red-500 hover:bg-red-50 py-3 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-times-circle"></i> Hủy đặt phòng
                    </button>
                </form>
                @endif
            </div>

            <!-- ═══ PHẦN ĐÁNH GIÁ — THÊM MỚI ═══ -->
            @php
                $userReview = \App\Models\Review::where('user_id', auth()->id())
                    ->where('hotel_id', $booking->hotel_id)
                    ->first();
            @endphp

            @if($booking->status === 'completed' && !$userReview)
            {{-- Đã completed, chưa đánh giá → hiện form --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-50">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-star text-amber-400 text-sm"></i>
                        Đánh giá chuyến đi của bạn
                    </h2>
                    <p class="text-slate-400 text-xs mt-1">Chia sẻ trải nghiệm để giúp những khách hàng khác</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="hotel_id" value="{{ $booking->hotel_id }}">

                        @if($errors->has('review'))
                        <div class="bg-red-50 border border-red-200 text-red-500 text-xs px-3 py-2 rounded-lg mb-4 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('review') }}
                        </div>
                        @endif

                        <!-- Stars -->
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">
                                Đánh giá sao
                            </label>
                            <div class="flex gap-3">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button"
                                    onclick="setRating({{ $i }})"
                                    id="star-{{ $i }}"
                                    class="text-3xl text-slate-200 hover:text-amber-400 transition-colors">
                                    <i class="fas fa-star"></i>
                                </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="">
                            <p class="text-slate-400 text-xs mt-2" id="ratingText">Click để chọn số sao</p>
                        </div>

                        <!-- Comment -->
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">
                                Nhận xét
                            </label>
                            <textarea name="comment" rows="4"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                placeholder="Chia sẻ trải nghiệm của bạn về {{ $booking->hotel->name }}...">{{ old('comment') }}</textarea>
                        </div>

                        <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i> Gửi đánh giá
                        </button>
                    </form>
                </div>
            </div>

            @elseif($booking->status === 'completed' && $userReview)
            {{-- Đã completed + đã đánh giá → hiện review --}}
            <div class="bg-emerald-50 rounded-2xl border border-emerald-100 p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-emerald-600 text-lg"></i>
                </div>
                <div>
                    <p class="font-bold text-emerald-700">Bạn đã đánh giá chuyến đi này!</p>
                    <div class="flex gap-0.5 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-sm {{ $i <= $userReview->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                        @endfor
                    </div>
                    @if($userReview->comment)
                    <p class="text-emerald-600 text-sm mt-1 italic">"{{ $userReview->comment }}"</p>
                    @endif
                </div>
            </div>

            @elseif($booking->status === 'cancelled')
            {{-- Đã hủy → không thể đánh giá --}}
            <div class="bg-red-50 rounded-2xl border border-red-100 p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-times text-red-500 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-red-600">Không thể đánh giá</p>
                    <p class="text-red-400 text-sm mt-0.5">Đặt phòng đã bị hủy nên không thể đánh giá</p>
                </div>
            </div>

            @else
            {{-- pending hoặc confirmed → chưa hoàn thành --}}
            <div class="bg-slate-50 rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-slate-400 text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-slate-600">Chưa thể đánh giá</p>
                    <p class="text-slate-400 text-sm mt-0.5">Bạn có thể đánh giá sau khi hoàn thành chuyến đi</p>
                </div>
            </div>
            @endif
            {{-- ═══ KẾT THÚC PHẦN ĐÁNH GIÁ ═══ --}}

        </div>

        <!-- Cột phải - Payment Summary -->
        <div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden sticky top-20">
                <div class="bg-blue-600 px-6 py-5">
                    <p class="text-blue-200 text-xs font-medium mb-1">Tổng thanh toán</p>
                    <p class="text-white font-bold text-3xl">{{ number_format($booking->total_amount) }}đ</p>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">{{ number_format($booking->room_price_per_night) }}đ × {{ $booking->number_of_nights }} đêm</span>
                        <span class="text-slate-700 font-medium">{{ number_format($booking->subtotal) }}đ</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Thuế (10%)</span>
                        <span class="text-slate-700 font-medium">{{ number_format($booking->taxes) }}đ</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Phí dịch vụ</span>
                        <span class="text-slate-700 font-medium">{{ number_format($booking->service_fee) }}đ</span>
                    </div>
                    @if($booking->discount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-emerald-500">Giảm giá</span>
                        <span class="text-emerald-500 font-medium">-{{ number_format($booking->discount) }}đ</span>
                    </div>
                    @endif
                    <div class="flex justify-between font-bold text-slate-800 pt-3 border-t border-slate-100">
                        <span>Tổng cộng</span>
                        <span class="text-blue-600 text-lg">{{ number_format($booking->total_amount) }}đ</span>
                    </div>
                </div>

                <!-- Trust -->
                <div class="px-5 pb-5 space-y-2">
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <i class="fas fa-shield-alt text-emerald-500"></i>
                        <span>Thanh toán an toàn & bảo mật</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <i class="fas fa-headset text-blue-500"></i>
                        <span>Hỗ trợ 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const ratingTexts = ['', 'Rất tệ', 'Tệ', 'Bình thường', 'Tốt', 'Xuất sắc'];

function setRating(rating) {
    document.getElementById('ratingInput').value = rating;
    document.getElementById('ratingText').textContent = ratingTexts[rating];
    document.getElementById('ratingText').style.color = '#f59e0b';
    for (let i = 1; i <= 5; i++) {
        document.getElementById('star-' + i).style.color = i <= rating ? '#f59e0b' : '#e2e8f0';
    }
}
</script>
@endpush

@endsection