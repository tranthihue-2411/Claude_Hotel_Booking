<?php
// File: app/Models/User.php
// Thêm vào model User có sẵn của Laravel Breeze

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_admin',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_admin'          => 'boolean',
    ];

    // ===== RELATIONSHIPS =====

    // Quản lý nhiều khách sạn
    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
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

    // ===== METHODS =====

    // Kiểm tra có phải admin không
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }
}