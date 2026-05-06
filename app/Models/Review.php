<?php
// File: app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    // Các trường được phép gán hàng loạt
    protected $fillable = [
        'user_id', 'hotel_id', 'booking_id',
        'rating', 'comment',
        'is_verified', 'is_published',
    ];

    // Kiểu dữ liệu tự động chuyển đổi
    protected $casts = [
        'is_verified'  => 'boolean',
        'is_published' => 'boolean',
    ];

    // ===== RELATIONSHIPS =====

    // Thuộc về người dùng nào
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Thuộc về khách sạn nào
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    // Thuộc về booking nào
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}