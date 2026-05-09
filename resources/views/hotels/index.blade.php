@extends('layouts.app')

@section('title', 'HotelHub - Trang chủ')

@section('content')

@push('styles')
<style>
    .hero-bg {
        background: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1600&h=900&fit=crop&q=85') center/cover no-repeat;
        min-height: 580px;
    }
    .hero-overlay {
        background: linear-gradient(to bottom, rgba(8,20,50,0.72) 0%, rgba(8,20,50,0.55) 100%);
    }
    .search-card {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.6);
    }
    .hotel-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hotel-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px rgba(37,99,235,0.13);
    }
    .hotel-card img {
        transition: transform 0.5s ease;
    }
    .hotel-card:hover img {
        transform: scale(1.06);
    }
    .stat-card {
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
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
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    .label-text {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 6px;
        display: block;
        text-align: left;
    }
    .cta-bg {
        background: url('https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=1400&h=400&fit=crop&q=80') center/cover no-repeat;
    }
</style>
@endpush

<!-- ═══════════════ HERO ═══════════════ -->
<div class="hero-bg relative flex items-center">
    <div class="hero-overlay absolute inset-0"></div>
    <div class="relative z-10 w-full max-w-6xl mx-auto px-6 py-24 text-center">

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur border border-white/20 text-blue-200 text-xs font-semibold px-4 py-2 rounded-full mb-6 tracking-wider uppercase">
            <i class="fas fa-shield-alt text-blue-300"></i>
            Hệ thống đặt phòng uy tín hàng đầu Việt Nam
        </div>

        <h1 class="text-5xl md:text-6xl font-bold text-white mb-5 leading-tight tracking-tight">
            Tìm Khách Sạn<br>
            <span class="text-blue-300">Hoàn Hảo</span> Cho Bạn
        </h1>
        <p class="text-slate-300 text-lg mb-12 max-w-xl mx-auto">
            Hàng nghìn khách sạn trên khắp Việt Nam — giá tốt nhất, đặt nhanh nhất
        </p>

        <!-- Search Box -->
        <div class="search-card rounded-2xl p-6 max-w-4xl mx-auto shadow-2xl">
            <form action="{{ route('hotels.search') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="label-text">📍 Địa điểm</label>
                        <div class="relative">
                            <input type="text" name="location" class="input-field pl-10"
                                placeholder="Hà Nội, Đà Nẵng, TP.HCM...">
                            <i class="fas fa-search absolute left-3 top-3 text-slate-300 text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <label class="label-text">📅 Nhận phòng</label>
                        <input type="date" name="checkin" class="input-field" min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="label-text">📅 Trả phòng</label>
                        <input type="date" name="checkout" class="input-field" min="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-sm tracking-wide">
                    <i class="fas fa-search"></i>
                    Tìm kiếm khách sạn
                </button>
            </form>
        </div>

        <!-- Quick Stats bên dưới search -->
        <div class="flex items-center justify-center gap-8 mt-8 text-white/70 text-sm">
            <div class="flex items-center gap-2">
                <i class="fas fa-hotel text-blue-300"></i>
                <span>{{ $hotels->count() }}+ Khách sạn</span>
            </div>
            <div class="w-1 h-1 bg-white/30 rounded-full"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-star text-yellow-300"></i>
                <span>Đánh giá 4.8/5</span>
            </div>
            <div class="w-1 h-1 bg-white/30 rounded-full"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-lock text-green-300"></i>
                <span>Đặt phòng an toàn</span>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════ STATS BAR ═══════════════ -->
<div class="bg-white border-b border-slate-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-3 divide-x divide-slate-100">
            <div class="stat-card flex items-center justify-center gap-4 py-6 px-8">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-hotel text-blue-600 text-lg"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">{{ $hotels->count() }}+</div>
                    <div class="text-xs text-slate-400 font-medium mt-0.5">Khách sạn toàn quốc</div>
                </div>
            </div>
            <div class="stat-card flex items-center justify-center gap-4 py-6 px-8">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar-check text-emerald-600 text-lg"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">1,000+</div>
                    <div class="text-xs text-slate-400 font-medium mt-0.5">Đặt phòng thành công</div>
                </div>
            </div>
            <div class="stat-card flex items-center justify-center gap-4 py-6 px-8">
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-star text-amber-500 text-lg"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">4.8 / 5</div>
                    <div class="text-xs text-slate-400 font-medium mt-0.5">Điểm đánh giá trung bình</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════ FEATURED HOTELS ═══════════════ -->
<div class="max-w-6xl mx-auto px-6 py-16">
    <!-- Header -->
    <div class="flex items-end justify-between mb-10">
        <div>
            <p class="text-blue-600 text-xs font-bold uppercase tracking-widest mb-2">
                <i class="fas fa-fire mr-1"></i> Nổi bật
            </p>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Khách Sạn Được Yêu Thích Nhất</h2>
            <p class="text-slate-400 text-sm mt-1">Được chọn lọc dựa trên đánh giá của khách hàng</p>
        </div>
        <a href="{{ route('hotels.search') }}"
            class="hidden md:flex items-center gap-2 text-blue-600 hover:text-blue-700 text-sm font-semibold border border-blue-200 hover:border-blue-400 px-4 py-2 rounded-xl transition-all duration-200">
            Xem tất cả <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($hotels as $hotel)
        <div class="hotel-card bg-white rounded-2xl overflow-hidden border border-slate-100">
            <!-- Image -->
            <div class="relative overflow-hidden h-52">
                <img src="{{ $hotel->main_image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&h=600&fit=crop' }}"
                    alt="{{ $hotel->name }}"
                    class="w-full h-full object-cover">

                <!-- Rating -->
                <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm rounded-full px-2.5 py-1 flex items-center gap-1.5 shadow-md">
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <span class="text-xs font-bold text-slate-800">{{ number_format($hotel->rating, 1) }}</span>
                </div>

                <!-- Location -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent px-4 py-3">
                    <p class="text-white text-xs font-medium">
                        <i class="fas fa-map-marker-alt mr-1 text-blue-300"></i>
                        {{ $hotel->city }}, {{ $hotel->province }}
                    </p>
                </div>
            </div>

            <!-- Body -->
            <div class="p-5">
                <h3 class="font-bold text-slate-800 text-base mb-1 leading-snug">{{ $hotel->name }}</h3>
                <p class="text-slate-400 text-xs leading-relaxed mb-4 line-clamp-2">{{ $hotel->description }}</p>

                <!-- Amenities -->
                @if($hotel->amenities && $hotel->amenities->count() > 0)
                <div class="flex gap-1.5 mb-4 flex-wrap">
                    @foreach($hotel->amenities->take(3) as $amenity)
                    <span class="bg-slate-50 text-slate-500 text-xs px-2 py-1 rounded-lg border border-slate-100">
                        {{ $amenity->icon }} {{ $amenity->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                <!-- Footer -->
                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                    <div>
                        <span class="text-slate-400 text-xs">Từ</span>
                        <span class="text-blue-600 font-bold text-2xl ml-1">
                            ${{ number_format($hotel->rooms->min('price_per_night') ?? 0) }}
                        </span>
                        <span class="text-slate-400 text-xs">/đêm</span>
                    </div>
                    <a href="{{ route('hotels.show', $hotel) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition-colors duration-200 flex items-center gap-1.5">
                        Xem chi tiết
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Mobile see all -->
    <div class="text-center mt-8 md:hidden">
        <a href="{{ route('hotels.search') }}"
            class="inline-flex items-center gap-2 border-2 border-blue-600 text-blue-600 px-6 py-3 rounded-xl font-semibold text-sm hover:bg-blue-600 hover:text-white transition-all duration-200">
            Xem tất cả khách sạn <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>
</div>

<!-- ═══════════════ CTA BANNER ═══════════════ -->
<div class="max-w-6xl mx-auto px-6 pb-16">
    <div class="cta-bg relative rounded-3xl overflow-hidden">
        <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(8,20,60,0.85) 0%, rgba(37,99,235,0.75) 100%);"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between px-10 py-12 gap-6">
            <div>
                <p class="text-blue-300 text-xs font-bold uppercase tracking-widest mb-2">
                    <i class="fas fa-bolt mr-1"></i> Đặt ngay hôm nay
                </p>
                <h3 class="text-2xl font-bold text-white mb-2 leading-snug">
                    Hàng nghìn lựa chọn đang chờ bạn
                </h3>
                <p class="text-slate-300 text-sm">Giá tốt nhất, đặt phòng dễ dàng, hỗ trợ 24/7</p>
            </div>
            <a href="{{ route('hotels.search') }}"
                class="bg-white hover:bg-blue-50 text-blue-700 font-bold px-8 py-3.5 rounded-xl transition-colors duration-200 whitespace-nowrap text-sm flex items-center gap-2 shadow-lg">
                Khám phá ngay
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@endsection