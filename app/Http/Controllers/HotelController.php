<?php
// File: app/Http/Controllers/HotelController.php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // Trang chủ — danh sách khách sạn nổi bật
    public function index()
    {
        $hotels = Hotel::active()
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return view('hotels.index', compact('hotels'));
    }

    // Tìm kiếm khách sạn theo điều kiện
    public function search(Request $request)
    {
        $query = Hotel::active();

        // Tìm theo địa điểm (city hoặc province)
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function ($q) use ($location) {
                $q->where('city', 'like', "%{$location}%")
                  ->orWhere('province', 'like', "%{$location}%")
                  ->orWhere('address', 'like', "%{$location}%");
            });
        }

        // Lọc theo khoảng giá (qua bảng rooms)
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('rooms', function ($q) use ($request) {
                if ($request->filled('min_price')) {
                    $q->where('price_per_night', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('price_per_night', '<=', $request->max_price);
                }
            });
        }

        // Lọc theo rating tối thiểu
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Sắp xếp kết quả
        $sortBy = $request->get('sort_by', 'rating');
        match ($sortBy) {
            'price_asc'  => $query->join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
                                   ->orderBy('rooms.price_per_night', 'asc')
                                   ->select('hotels.*'),
            'price_desc' => $query->join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
                                   ->orderBy('rooms.price_per_night', 'desc')
                                   ->select('hotels.*'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->orderBy('rating', 'desc'),
        };

        $hotels = $query->paginate(12)->withQueryString();

        return view('hotels.search', compact('hotels'));
    }

    // Chi tiết khách sạn
    public function show($id)
    {
        $hotel = Hotel::with([
            'rooms'     => fn($q) => $q->active(),
            'reviews'   => fn($q) => $q->where('is_published', true)
                                        ->latest()
                                        ->take(10),
            'amenities',
        ])->findOrFail($id);

        return view('hotels.show', compact('hotel'));
    }
}