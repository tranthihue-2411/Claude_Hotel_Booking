<?php
// File: app/Models/Hotel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    // Các trường được phép gán hàng loạt
    protected $fillable = [
        'name', 'description', 'address',
        'city', 'province', 'country',
        'phone', 'email', 'website',
        'latitude', 'longitude',
        'rating', 'review_count',
        'main_image', 'images',
        'is_active', 'user_id',
    ];

    // Kiểu dữ liệu tự động chuyển đổi
    protected $casts = [
        'images'    => 'array',
        'is_active' => 'boolean',
        'rating'    => 'decimal:2',
    ];

    // ===== RELATIONSHIPS =====

    // Thuộc về admin nào quản lý
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Có nhiều phòng
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    // Có nhiều đặt phòng
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Có nhiều đánh giá
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Có nhiều tiện nghi (qua bảng hotel_amenities)
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'hotel_amenities');
    }

    // ===== SCOPES =====

    // Chỉ lấy khách sạn đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ===== METHODS =====

    // Cập nhật rating trung bình từ các đánh giá đã publish
    public function updateRating(): void
    {
        $avg = $this->reviews()
                    ->where('is_published', true)
                    ->avg('rating');

        $count = $this->reviews()
                      ->where('is_published', true)
                      ->count();

        $this->update([
            'rating'       => round($avg ?? 0, 2),
            'review_count' => $count,
        ]);
    }
}