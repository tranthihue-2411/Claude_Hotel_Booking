<?php
// File: app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    // Các trường được phép gán hàng loạt
    protected $fillable = [
        'booking_reference', 'user_id',
        'hotel_id', 'room_id',
        'check_in_date', 'check_out_date',
        'number_of_guests', 'number_of_nights',
        'room_price_per_night', 'subtotal',
        'taxes', 'service_fee', 'discount',
        'total_amount', 'guest_name',
        'guest_email', 'guest_phone',
        'special_requests', 'status',
        'cancelled_at', 'cancellation_reason',
    ];

    // Kiểu dữ liệu tự động chuyển đổi
    protected $casts = [
        'check_in_date'  => 'date',
        'check_out_date' => 'date',
        'cancelled_at'   => 'datetime',
        'total_amount'   => 'decimal:2',
    ];

    // ===== RELATIONSHIPS =====

    // Thuộc về khách hàng nào
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Thuộc về khách sạn nào
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    // Thuộc về phòng nào
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Có 1 đánh giá
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    // ===== METHODS =====

    // Hủy đặt phòng
    public function cancel(?string $reason = null): void
    {
        $this->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $reason,
        ]);
    }
}