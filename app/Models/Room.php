<?php
// File: app/Models/Room.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    // Các trường được phép gán hàng loạt
    protected $fillable = [
        'hotel_id', 'name', 'description',
        'room_type', 'max_guests', 'size_sqm',
        'bed_type', 'price_per_night',
        'total_rooms', 'amenities',
        'image', 'is_active',
    ];

    // Kiểu dữ liệu tự động chuyển đổi
    protected $casts = [
        'amenities'       => 'array',
        'is_active'       => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    // ===== RELATIONSHIPS =====

    // Thuộc về khách sạn nào
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    // Có nhiều đặt phòng
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // ===== SCOPES =====

    // Chỉ lấy phòng đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ===== METHODS =====

    // Kiểm tra phòng còn trống trong khoảng thời gian
    public function isAvailable(string $checkIn, string $checkOut): bool
    {
        $bookedCount = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                      });
            })
            ->count();

        return $bookedCount < $this->total_rooms;
    }
}