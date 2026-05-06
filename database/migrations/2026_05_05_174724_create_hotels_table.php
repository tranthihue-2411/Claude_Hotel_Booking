<?php
// File: database/migrations/xxxx_create_hotels_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();

            // Thông tin cơ bản
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('city', 100);
            $table->string('province', 100);
            $table->string('country', 100)->default('Vietnam');

            // Liên hệ
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Tọa độ GPS
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Đánh giá
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('review_count')->default(0);

            // Hình ảnh
            $table->string('main_image')->nullable();
            $table->json('images')->nullable();

            // Trạng thái
            $table->boolean('is_active')->default(true);

            // Quản lý bởi admin
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            // Indexes
            $table->index('city');
            $table->index('province');
            $table->index('is_active');
            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};