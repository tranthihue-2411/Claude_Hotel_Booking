<?php
// File: app/Http/Controllers/Admin/AdminDashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\User;

class AdminDashboardController extends Controller
{
    // Kiểm tra quyền Admin
    private function checkAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    // Trang dashboard thống kê
    public function index()
    {
        $this->checkAdmin();

        // Thống kê tổng hợp
        $stats = [
            'total_hotels'   => Hotel::count(),
            'total_bookings' => Booking::count(),
            'total_users'    => User::where('is_admin', false)->count(),
            'total_revenue'  => Booking::where('status', 'completed')
                                        ->sum('total_amount'),
        ];

        // 10 booking mới nhất
        $recentBookings = Booking::with(['user', 'hotel', 'room'])
            ->latest()
            ->take(10)
            ->get();

        // Top 5 khách sạn có nhiều booking nhất
        $topHotels = Hotel::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentBookings', 'topHotels'
        ));
    }
}