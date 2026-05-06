<?php
// File: database/migrations/xxxx_create_hotel_amenities_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_amenities', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('hotel_id')
                  ->constrained('hotels')
                  ->cascadeOnDelete();

            $table->foreignId('amenity_id')
                  ->constrained('amenities')
                  ->cascadeOnDelete();

            $table->timestamps();

            // Mỗi khách sạn chỉ có 1 tiện nghi mỗi loại
            $table->unique(['hotel_id', 'amenity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_amenities');
    }
};