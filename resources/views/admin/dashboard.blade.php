@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin HotelHub')
@section('page-title', 'Dashboard')

@section('content')
<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Tổng doanh thu</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">${{ number_format($totalRevenue) }}</p>
                <p class="text-sm mt-1 {{ $revenueTrend >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    <i class="fas fa-arrow-{{ $revenueTrend >= 0 ? 'up' : 'down' }} mr-1"></i>
                    {{ abs($revenueTrend) }}% so với tháng trước
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Bookings -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Tổng đặt phòng</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBookings }}</p>
                <p class="text-sm mt-1 {{ $bookingTrend >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    <i class="fas fa-arrow-{{ $bookingTrend >= 0 ? 'up' : 'down' }} mr-1"></i>
                    {{ abs($bookingTrend) }} so với tháng trước
                </p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Tổng người dùng</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
                <p class="text-sm text-gray-400 mt-1">Tài khoản đã đăng ký</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Hotels -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Tổng khách sạn</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalHotels }}</p>
                <p class="text-sm text-gray-400 mt-1">Đang hoạt động</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-hotel text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Bookings -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-gray-800">Đặt phòng gần đây</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:underline text-sm">Xem tất cả</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-gray-500 text-sm border-b">
                        <th class="pb-3">Mã đặt phòng</th>
                        <th class="pb-3">Khách hàng</th>
                        <th class="pb-3">Khách sạn</th>
                        <th class="pb-3">Trạng thái</th>
                        <th class="pb-3">Tổng tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentBookings as $booking)
                    <tr class="text-sm">
                        <td class="py-3 font-medium text-blue-600">
                            <a href="{{ route('admin.bookings.show', $booking) }}">
                                {{ $booking->booking_reference }}
                            </a>
                        </td>
                        <td class="py-3 text-gray-700">{{ $booking->guest_name }}</td>
                        <td class="py-3 text-gray-700">{{ $booking->hotel->name }}</td>
                        <td class="py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="py-3 font-medium text-gray-800">${{ number_format($booking->total_amount) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Hotels -->
    <div class="bg-white rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-5">Khách sạn nổi bật</h2>
        <div class="space-y-4">
            @foreach($topHotels as $index => $hotel)
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800 text-sm">{{ $hotel->name }}</p>
                    <p class="text-gray-400 text-xs">{{ $hotel->bookings_count }} đặt phòng</p>
                </div>
                <div class="flex items-center text-yellow-400 text-sm">
                    <i class="fas fa-star mr-1"></i>
                    <span class="text-gray-700">{{ number_format($hotel->rating, 1) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Booking Status Summary -->
        <div class="mt-6 pt-6 border-t">
            <h3 class="font-bold text-gray-800 mb-3 text-sm">Theo trạng thái</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-green-600"><i class="fas fa-circle text-xs mr-1"></i>Confirmed</span>
                    <span class="font-medium">{{ $bookingsByStatus['confirmed'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-yellow-600"><i class="fas fa-circle text-xs mr-1"></i>Pending</span>
                    <span class="font-medium">{{ $bookingsByStatus['pending'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-red-600"><i class="fas fa-circle text-xs mr-1"></i>Cancelled</span>
                    <span class="font-medium">{{ $bookingsByStatus['cancelled'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-blue-600"><i class="fas fa-circle text-xs mr-1"></i>Completed</span>
                    <span class="font-medium">{{ $bookingsByStatus['completed'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection