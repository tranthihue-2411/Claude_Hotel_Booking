@extends('layouts.app')

@section('title', 'Tìm kiếm khách sạn - HotelHub')

@push('styles')
<style>
    .hotel-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hotel-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(37,99,235,0.12);
    }
    .hotel-card img {
        transition: transform 0.5s ease;
    }
    .hotel-card:hover img {
        transform: scale(1.05);
    }
    .filter-section {
        position: sticky;
        top: 80px;
    }
    .input-field {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 9px 14px;
        font-size: 14px;
        color: #1e293b;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
        background: #fff;
    }
    .input-field:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 6px 0;
        font-size: 13px;
        color: #475569;
        transition: color 0.2s;
    }
    .checkbox-label:hover { color: #2563eb; }
    .checkbox-label input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #2563eb;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')

<!-- Page Header -->
<div class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6 py-5">
        <div class="flex items-center gap-2 text-sm text-slate-400 mb-1">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Trang chủ</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-slate-600 font-medium">Tìm kiếm khách sạn</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800">
            Tìm thấy <span class="text-blue-600">{{ $hotels->total() }}</span> khách sạn
            @if(request('location'))
                tại <span class="text-blue-600">"{{ request('location') }}"</span>
            @endif
        </h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex gap-8">

        <!-- ═══ SIDEBAR FILTER ═══ -->
        <div class="w-72 flex-shrink-0">
            <div class="filter-section bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                <!-- Filter Header -->
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-sliders-h text-blue-600 text-sm"></i>
                        Bộ lọc
                    </h3>
                    <a href="{{ route('hotels.search') }}" class="text-xs text-slate-400 hover:text-red-500 transition-colors">
                        Xóa tất cả
                    </a>
                </div>

                <form action="{{ route('hotels.search') }}" method="GET" class="p-5 space-y-6">

                    <!-- Location -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                            📍 Địa điểm
                        </label>
                        <div class="relative">
                            <input type="text" name="location" value="{{ request('location') }}"
                                class="input-field pl-9"
                                placeholder="Thành phố...">
                            <i class="fas fa-search absolute left-3 top-3 text-slate-300 text-xs"></i>
                        </div>
                    </div>

                    <div class="border-t border-slate-50"></div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                            💰 Giá phòng / đêm ($)
                        </label>
                        <div class="flex gap-2 items-center">
                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                class="input-field text-center" placeholder="Từ">
                            <span class="text-slate-300 flex-shrink-0">—</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                class="input-field text-center" placeholder="Đến">
                        </div>
                    </div>

                    <div class="border-t border-slate-50"></div>

                    <!-- Rating -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                            ⭐ Đánh giá
                        </label>
                        @foreach([5, 4, 3] as $star)
                        <label class="checkbox-label">
                            <input type="checkbox" name="rating[]" value="{{ $star }}"
                                {{ in_array($star, (array)request('rating', [])) ? 'checked' : '' }}>
                            <div class="flex items-center gap-1.5">
                                <div class="flex">
                                    @for($i = 0; $i < $star; $i++)
                                    <i class="fas fa-star text-amber-400 text-xs"></i>
                                    @endfor
                                    @for($i = $star; $i < 5; $i++)
                                    <i class="fas fa-star text-slate-200 text-xs"></i>
                                    @endfor
                                </div>
                                <span>{{ $star }} sao</span>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-50"></div>

                    <!-- Amenities -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">
                            🛎️ Tiện nghi
                        </label>
                        @foreach($amenities as $amenity)
                        <label class="checkbox-label">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                {{ in_array($amenity->id, (array)request('amenities', [])) ? 'checked' : '' }}>
                            <span>{{ $amenity->icon }} {{ $amenity->name }}</span>
                        </label>
                        @endforeach
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-colors duration-200 text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i> Áp dụng bộ lọc
                    </button>
                </form>
            </div>
        </div>

        <!-- ═══ HOTEL LIST ═══ -->
        <div class="flex-1 min-w-0">

            <!-- Sort Bar -->
            <div class="flex items-center justify-between mb-6 bg-white rounded-xl border border-slate-100 px-5 py-3 shadow-sm">
                <p class="text-sm text-slate-500">
                    Hiển thị <span class="font-semibold text-slate-700">{{ $hotels->count() }}</span>
                    / <span class="font-semibold text-slate-700">{{ $hotels->total() }}</span> kết quả
                </p>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-400 font-medium">Sắp xếp:</span>
                    <form method="GET" action="{{ route('hotels.search') }}" id="sort-form">
                        @foreach(request()->except('sort') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="sort" onchange="document.getElementById('sort-form').submit()"
                            class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="rating-desc" {{ request('sort') == 'rating-desc' ? 'selected' : '' }}>⭐ Đánh giá cao nhất</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>💰 Giá thấp nhất</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>💎 Giá cao nhất</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Hotels -->
            @forelse($hotels as $hotel)
            <div class="hotel-card bg-white rounded-2xl border border-slate-100 overflow-hidden mb-5 shadow-sm">
                <div class="flex">
                    <!-- Image -->
                    <div class="w-64 flex-shrink-0 overflow-hidden">
                        <img src="{{ $hotel->main_image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&h=600&fit=crop' }}"
                            alt="{{ $hotel->name }}"
                            class="w-full h-full object-cover" style="min-height: 200px;">
                    </div>

                    <!-- Content -->
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <!-- Top Row -->
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h3 class="text-lg font-bold text-slate-800 leading-snug">{{ $hotel->name }}</h3>
                                <div class="flex items-center gap-1.5 bg-blue-600 text-white px-3 py-1.5 rounded-xl flex-shrink-0">
                                    <i class="fas fa-star text-amber-300 text-xs"></i>
                                    <span class="font-bold text-sm">{{ number_format($hotel->rating, 1) }}</span>
                                </div>
                            </div>

                            <!-- Location -->
                            <p class="text-slate-400 text-sm mb-3 flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-blue-400 text-xs"></i>
                                {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->province }}
                            </p>

                            <!-- Description -->
                            <p class="text-slate-500 text-sm leading-relaxed mb-4 line-clamp-2">
                                {{ $hotel->description }}
                            </p>

                            <!-- Amenities -->
                            @if($hotel->amenities->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($hotel->amenities->take(4) as $amenity)
                                <span class="bg-slate-50 text-slate-500 text-xs px-2.5 py-1 rounded-lg border border-slate-100">
                                    {{ $amenity->icon }} {{ $amenity->name }}
                                </span>
                                @endforeach
                                @if($hotel->amenities->count() > 4)
                                <span class="bg-slate-50 text-slate-400 text-xs px-2.5 py-1 rounded-lg border border-slate-100">
                                    +{{ $hotel->amenities->count() - 4 }} tiện nghi
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Bottom Row -->
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50 mt-4">
                            <div>
                                <span class="text-slate-400 text-xs">Chỉ từ</span>
                                <span class="text-blue-600 font-bold text-2xl ml-1">
                                    ${{ number_format($hotel->rooms->min('price_per_night') ?? 0) }}
                                </span>
                                <span class="text-slate-400 text-xs">/đêm</span>
                            </div>
                            <a href="{{ route('hotels.show', $hotel) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors duration-200 flex items-center gap-2">
                                Xem chi tiết
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-slate-100 p-16 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-slate-300 text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-600 mb-2">Không tìm thấy khách sạn</h3>
                <p class="text-slate-400 text-sm mb-6">Thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác</p>
                <a href="{{ route('hotels.search') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fas fa-refresh"></i> Xóa bộ lọc
                </a>
            </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-6">
                {{ $hotels->links() }}
            </div>
        </div>
    </div>
</div>

@endsection