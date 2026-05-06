<?php
// File: app/Http/Controllers/Admin/AdminBookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // Kiểm tra quyền Admin
    private function checkAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    // Danh sách tất cả bookings (có filter theo status)
    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = Booking::with(['user', 'hotel', 'room'])->latest();

        // Filter theo status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    // Chi tiết booking
    public function show($id)
    {
        $this->checkAdmin();

        $booking = Booking::with(['user', 'hotel', 'room', 'review'])
            ->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    // Cập nhật trạng thái booking
    public function updateStatus(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }
}