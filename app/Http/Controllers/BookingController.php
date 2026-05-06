<?php
// File: app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Form đặt phòng
    public function create(Request $request, $roomId)
    {
        // Kiểm tra đã đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để đặt phòng.');
        }

        $room  = Room::with('hotel')->findOrFail($roomId);
        $hotel = $room->hotel;

        return view('bookings.create', compact('room', 'hotel'));
    }

    // Lưu booking mới
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'check_in_date'    => 'required|date|after_or_equal:today',
            'check_out_date'   => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'guest_name'       => 'required|string|max:255',
            'guest_email'      => 'required|email|max:255',
            'guest_phone'      => 'nullable|string|max:20',
            'special_requests' => 'nullable|string',
        ]);

        $room  = Room::with('hotel')->findOrFail($validated['room_id']);
        $hotel = $room->hotel;

        // Kiểm tra phòng còn trống
        if (!$room->isAvailable($validated['check_in_date'], $validated['check_out_date'])) {
            return back()->with('error', 'Phòng không còn trống trong khoảng thời gian này.');
        }

        // Tính toán số đêm và tổng tiền
        $checkIn  = \Carbon\Carbon::parse($validated['check_in_date']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out_date']);
        $nights   = $checkIn->diffInDays($checkOut);

        $subtotal   = $room->price_per_night * $nights;
        $taxes      = $subtotal * 0.08; // Thuế 8%
        $serviceFee = $subtotal * 0.05; // Phí dịch vụ 5%
        $total      = $subtotal + $taxes + $serviceFee;

        // Tạo mã đặt phòng unique
        $bookingReference = 'BK-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));

        // Lưu booking
        $booking = Booking::create([
            'booking_reference'    => $bookingReference,
            'user_id'              => Auth::id(),
            'hotel_id'             => $hotel->id,
            'room_id'              => $room->id,
            'check_in_date'        => $validated['check_in_date'],
            'check_out_date'       => $validated['check_out_date'],
            'number_of_guests'     => $validated['number_of_guests'],
            'number_of_nights'     => $nights,
            'room_price_per_night' => $room->price_per_night,
            'subtotal'             => $subtotal,
            'taxes'                => $taxes,
            'service_fee'          => $serviceFee,
            'discount'             => 0,
            'total_amount'         => $total,
            'guest_name'           => $validated['guest_name'],
            'guest_email'          => $validated['guest_email'],
            'guest_phone'          => $validated['guest_phone'] ?? null,
            'special_requests'     => $validated['special_requests'] ?? null,
            'status'               => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Đặt phòng thành công! Mã đặt phòng: ' . $bookingReference);
    }

    // Danh sách booking của user hiện tại
    public function index()
    {
        $bookings = Booking::with(['hotel', 'room'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    // Chi tiết booking
    public function show($id)
    {
        $booking = Booking::with(['hotel', 'room', 'review'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('bookings.show', compact('booking'));
    }

    // Hủy booking
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->findOrFail($id);

        // Chỉ hủy được khi status là pending hoặc confirmed
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Không thể hủy booking ở trạng thái này.');
        }

        $booking->cancel('Khách hàng yêu cầu hủy');

        return redirect()->route('bookings.index')
            ->with('success', 'Hủy đặt phòng thành công.');
    }
}