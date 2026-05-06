<?php
// File: database/migrations/xxxx_create_rooms_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            // Thuộc khách sạn nào
            $table->foreignId('hotel_id')
                  ->constrained('hotels')
                  ->cascadeOnDelete();

            // Thông tin phòng
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('room_type', ['Single', 'Double', 'Suite', 'Villa']);
            $table->unsignedInteger('max_guests');
            $table->decimal('size_sqm', 8, 2)->nullable();
            $table->string('bed_type', 100)->nullable();

            // Giá và số lượng
            $table->decimal('price_per_night', 10, 2);
            $table->unsignedInteger('total_rooms');

            // Tiện nghi và hình ảnh
            $table->json('amenities')->nullable();
            $table->string('image')->nullable();

            // Trạng thái
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('hotel_id');
            $table->index('price_per_night');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};