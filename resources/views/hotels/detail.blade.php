@extends('layouts.app')

@section('title', $hotel->name . ' - HotelHub')

@push('styles')
<style>
    .input-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 13px;
        color: #1e293b;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
    }
    .input-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }
    .booking-sticky {
        position: sticky;
        top: 80px;
    }
    .room-card {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .room-card:hover { border-color: #93c5fd; background: #f8faff; }
    .room-card.selected { border-color: #2563eb; background: #eff6ff; }
</style>
@endpush

@section('content')

<!-- Breadcrumb -->
<div class="bg-white border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-6 py-3">
        <div class="flex items-center gap-2 text-sm text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('hotels.search') }}" class="hover:text-blue-600 transition-colors">Khách sạn</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-slate-600 font-medium">{{ $hotel->name }}</span>
        </div>
    </div>
</div>

<!-- ẢNH FULL WIDTH -->
<div class="w-full" style="height: 400px; overflow: hidden;">
    <img src="{{ $hotel->main_image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&h=600&fit=crop' }}"
        alt="{{ $hotel->name }}"
        class="w-full h-full object-cover">
</div>

<!-- MAIN CONTENT -->
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex gap-8 items-start">

        <!-- ═══ CỘT TRÁI ═══ -->
        <div class="flex-1 min-w-0">

            <!-- Hotel Info Card -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm mb-5">
                <div class="flex items-start justify-between mb-3">
                    <h1 class="text-2xl font-bold text-slate-800 leading-snug">{{ $hotel->name }}</h1>
                    <div class="flex gap-2 flex-shrink-0 ml-4">
                        <button class="flex items-center gap-1.5 border border-slate-200 text-slate-500 px-3 py-1.5 rounded-xl text-xs font-medium hover:bg-slate-50 transition-colors">
                            <i class="fas fa-heart text-red-400"></i> Lưu vào danh sách
                        </button>
                        <button class="flex items-center gap-1.5 border border-slate-200 text-slate-500 px-3 py-1.5 rounded-xl text-xs font-medium hover:bg-slate-50 transition-colors">
                            <i class="fas fa-share-alt text-blue-400"></i> Chia sẻ
                        </button>
                    </div>
                </div>

                <p class="text-slate-400 text-sm flex items-center gap-1.5 mb-3">
                    <i class="fas fa-map-marker-alt text-blue-500 text-xs"></i>
                    {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->province }}
                </p>

                <div class="flex items-center gap-2">
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-sm {{ $i <= round($hotel->rating) ? 'text-amber-400' : 'text-slate-200' }}"></i>
                        @endfor
                    </div>
                    <span class="font-bold text-slate-700 text-sm">{{ number_format($hotel->rating, 1) }}</span>
                    <span class="text-slate-400 text-sm">({{ $hotel->review_count }} đánh giá)</span>
                </div>
            </div>

            <!-- Mô tả -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm mb-5">
                <h2 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500 text-sm"></i> Mô tả
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $hotel->description }}</p>
            </div>

            <!-- Tiện ích -->
            @if($hotel->amenities->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm mb-5">
                <h2 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-concierge-bell text-blue-500 text-sm"></i> Tiện ích
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2.5">
                    @foreach($hotel->amenities as $amenity)
                    <div class="flex items-center gap-2 bg-slate-50 rounded-xl px-3 py-2.5 border border-slate-100">
                        <span>{{ $amenity->icon }}</span>
                        <span class="text-slate-600 text-sm">{{ $amenity->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Phòng có sẵn -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm mb-5">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-bed text-blue-500 text-sm"></i> Phòng có sẵn
                    </h2>
                    <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-2.5 py-1 rounded-lg border border-blue-100">
                        {{ $availableRooms->count() }} phòng trống
                    </span>
                </div>

                @forelse($availableRooms as $room)
                <div class="room-card border border-slate-100 rounded-xl overflow-hidden mb-3"
                    onclick="selectRoom({{ $room->id }}, {{ $room->price_per_night }}, '{{ $room->name }}')"
                    id="room-{{ $room->id }}">
                    <div class="flex">
                        <div class="w-36 flex-shrink-0 overflow-hidden">
                            <img src="{{ $room->image ?? 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=300&h=200&fit=crop' }}"
                                alt="{{ $room->name }}"
                                class="w-full h-full object-cover" style="min-height: 130px;">
                        </div>
                        <div class="flex-1 p-4">
                            <div class="flex items-start justify-between mb-1">
                                <h3 class="font-bold text-slate-800 text-sm">{{ $room->name }}</h3>
                                <div class="text-right ml-3 flex-shrink-0">
                                    <div class="text-blue-600 font-bold text-base">${{ number_format($room->price_per_night) }}</div>
                                    <div class="text-slate-400 text-xs">/đêm</div>
                                </div>
                            </div>
                            <p class="text-slate-400 text-xs mb-2 line-clamp-1">{{ $room->description }}</p>
                            <div class="flex items-center gap-3 text-xs text-slate-400 mb-2">
                                <span><i class="fas fa-bed mr-1 text-slate-300"></i>{{ $room->bed_type }}</span>
                                <span><i class="fas fa-user mr-1 text-slate-300"></i>{{ $room->max_guests }} khách</span>
                                @if($room->size_sqm)
                                <span><i class="fas fa-expand mr-1 text-slate-300"></i>{{ $room->size_sqm }}m²</span>
                                @endif
                            </div>
                            @if($room->amenities)
                            <div class="flex flex-wrap gap-1 mb-2">
                                @foreach($room->amenities as $a)
                                <span class="bg-slate-50 text-slate-400 text-xs px-2 py-0.5 rounded-lg border border-slate-100">{{ $a }}</span>
                                @endforeach
                            </div>
                            @endif
                            <p class="text-emerald-500 text-xs font-semibold">
                                <i class="fas fa-check-circle mr-1"></i>{{ $room->total_rooms }} phòng có sẵn
                                <span class="text-slate-300 ml-2">• Click để chọn</span>
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-bed text-slate-300 text-xl"></i>
                    </div>
                    <p class="text-slate-400 text-sm">Không có phòng trống trong thời gian này</p>
                </div>
                @endforelse
            </div>

            <!-- Đánh giá -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <i class="fas fa-star text-amber-400 text-sm"></i>
                    Đánh giá
                    <span class="text-slate-400 font-normal text-sm">({{ $hotel->review_count }})</span>
                </h2>
                @forelse($hotel->reviews as $review)
                <div class="flex items-start gap-3 py-4 border-b border-slate-50 last:border-0">
                    <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <p class="font-semibold text-slate-700 text-sm">{{ $review->user->name ?? 'Khách hàng' }}</p>
                            <span class="text-slate-300 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-0.5 mb-1.5">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $review->comment }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-6">
                    <p class="text-slate-400 text-sm">Chưa có đánh giá nào</p>
                </div>
                @endforelse
            </div>

        </div>

        <!-- ═══ CỘT PHẢI — BOOKING BOX STICKY ═══ -->
        <div class="w-80 flex-shrink-0">
            <div class="booking-sticky bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                <!-- Price Header -->
                <div class="bg-blue-600 px-6 py-5">
                    <p class="text-blue-200 text-xs font-medium mb-1">Đặt phòng</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-white font-bold text-3xl" id="displayPrice">
                            ${{ number_format($availableRooms->min('price_per_night') ?? 0) }}
                        </span>
                        <span class="text-blue-200 text-sm">/đêm</span>
                    </div>
                    <p class="text-blue-200 text-xs mt-1" id="selectedRoomName">Chọn phòng bên trái</p>
                </div>

                <div class="p-5">
                    @auth
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                        <input type="hidden" name="guest_email" value="{{ auth()->user()->email }}">
                        <input type="hidden" name="guest_name" value="{{ auth()->user()->name }}">
                        <input type="hidden" name="room_id" id="selectedRoomId" value="">

                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Nhận phòng</label>
                            <input type="date" name="check_in_date" id="checkIn"
                                required min="{{ date('Y-m-d') }}"
                                class="input-field" onchange="updatePrice()">
                        </div>

                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Trả phòng</label>
                            <input type="date" name="check_out_date" id="checkOut"
                                required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="input-field" onchange="updatePrice()">
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Khách</label>
                            <input type="number" name="number_of_guests"
                                value="2" min="1" max="10" required class="input-field">
                        </div>

                        <!-- Price Breakdown -->
                        <div id="priceBreakdown" class="bg-slate-50 rounded-xl p-4 mb-4 hidden border border-slate-100">
                            <div class="flex justify-between text-sm text-slate-500 mb-2">
                                <span id="priceLabel">$0 × 1 đêm</span>
                                <span id="subtotalVal">$0</span>
                            </div>
                            <div class="flex justify-between text-sm text-slate-500 mb-2">
                                <span>Thuế và phí</span>
                                <span id="taxVal">$0</span>
                            </div>
                            <div class="border-t border-slate-200 pt-2 mt-2 flex justify-between font-bold text-slate-800">
                                <span>Tổng cộng</span>
                                <span id="totalVal" class="text-blue-600">$0</span>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-calendar-check"></i> Đặt ngay
                        </button>

                        <p class="text-center text-slate-400 text-xs mt-2" id="bookHint">
                            Chọn phòng bên trái để tiếp tục
                        </p>
                    </form>
                    @else
                    <div class="text-center py-2">
                        <p class="text-slate-500 text-sm mb-4">Đăng nhập để đặt phòng ngay</p>
                        <a href="{{ route('login') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm transition-colors text-center mb-2">
                            <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập
                        </a>
                        <a href="{{ route('register') }}"
                            class="block w-full border border-blue-200 text-blue-600 py-3 rounded-xl font-semibold text-sm transition-colors text-center hover:bg-blue-50">
                            Đăng ký tài khoản
                        </a>
                    </div>
                    @endauth

                    <!-- Trust Badges -->
                    <div class="mt-4 pt-4 border-t border-slate-50 space-y-2">
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <i class="fas fa-shield-alt text-emerald-500"></i>
                            <span>Đặt phòng an toàn & bảo mật</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <i class="fas fa-undo text-blue-500"></i>
                            <span>Hủy miễn phí trước ngày nhận phòng</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <i class="fas fa-headset text-purple-500"></i>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
let selectedPrice = 0;

function selectRoom(roomId, price, name) {
    document.querySelectorAll('.room-card').forEach(card => card.classList.remove('selected'));
    document.getElementById('room-' + roomId).classList.add('selected');
    document.getElementById('selectedRoomId').value = roomId;
    selectedPrice = price;
    document.getElementById('displayPrice').textContent = '$' + price.toLocaleString();
    document.getElementById('selectedRoomName').textContent = name;
    document.getElementById('bookHint').textContent = 'Chọn ngày để xem tổng giá';
    updatePrice();
}

function updatePrice() {
    if (!selectedPrice) return;
    const checkIn = document.getElementById('checkIn').value;
    const checkOut = document.getElementById('checkOut').value;
    if (!checkIn || !checkOut) return;

    const nights = Math.max(1, Math.round((new Date(checkOut) - new Date(checkIn)) / 86400000));
    const subtotal = selectedPrice * nights;
    const tax = Math.round(subtotal * 0.1);
    const total = subtotal + tax + 15;

    document.getElementById('priceLabel').textContent = `$${selectedPrice} × ${nights} đêm`;
    document.getElementById('subtotalVal').textContent = `$${subtotal}`;
    document.getElementById('taxVal').textContent = `$${tax + 15}`;
    document.getElementById('totalVal').textContent = `$${total}`;
    document.getElementById('priceBreakdown').classList.remove('hidden');
    document.getElementById('bookHint').textContent = '';
}
</script>
@endpush

@endsection