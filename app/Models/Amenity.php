<?php
// File: app/Models/Amenity.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    // Các trường được phép gán hàng loạt
    protected $fillable = [
        'name', 'icon', 'category',
    ];

    // ===== RELATIONSHIPS =====

    // Thuộc về nhiều khách sạn (qua bảng hotel_amenities)
    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'hotel_amenities');
    }
}