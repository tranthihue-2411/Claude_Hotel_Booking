<?php
// File: app/Http/Controllers/Admin/AdminHotelController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHotelController extends Controller
{
    // Kiểm tra quyền Admin
    private function checkAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    }

    // Danh sách tất cả khách sạn
    public function index()
    {
        $this->checkAdmin();

        $hotels = Hotel::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.hotels.index', compact('hotels'));
    }

    // Form thêm khách sạn mới
    public function create()
    {
        $this->checkAdmin();

        $amenities = Amenity::orderBy('category')->get();

        return view('admin.hotels.create', compact('amenities'));
    }

    // Lưu khách sạn mới
    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'country'     => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'website'     => 'nullable|url|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'is_active'   => 'boolean',
            'main_image'  => 'nullable|image|max:2048',
            'amenities'   => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        // Xử lý upload ảnh chính
        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')
                ->store('hotels', 'public');
        }

        $validated['user_id']   = auth()->id();
        $validated['is_active'] = $request->boolean('is_active', true);

        $hotel = Hotel::create($validated);

        // Lưu tiện nghi
        if ($request->filled('amenities')) {
            $hotel->amenities()->sync($request->amenities);
        }

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Thêm khách sạn thành công.');
    }

    // Form sửa khách sạn
    public function edit($id)
    {
        $this->checkAdmin();

        $hotel     = Hotel::with('amenities')->findOrFail($id);
        $amenities = Amenity::orderBy('category')->get();

        return view('admin.hotels.edit', compact('hotel', 'amenities'));
    }

    // Cập nhật khách sạn
    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'province'    => 'required|string|max:100',
            'country'     => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'website'     => 'nullable|url|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'is_active'   => 'boolean',
            'main_image'  => 'nullable|image|max:2048',
            'amenities'   => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        // Xử lý upload ảnh mới
        if ($request->hasFile('main_image')) {
            // Xóa ảnh cũ
            if ($hotel->main_image) {
                Storage::disk('public')->delete($hotel->main_image);
            }
            $validated['main_image'] = $request->file('main_image')
                ->store('hotels', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $hotel->update($validated);

        // Cập nhật tiện nghi
        $hotel->amenities()->sync($request->amenities ?? []);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Cập nhật khách sạn thành công.');
    }

    // Xóa khách sạn
    public function destroy($id)
    {
        $this->checkAdmin();

        $hotel = Hotel::findOrFail($id);

        // Xóa ảnh nếu có
        if ($hotel->main_image) {
            Storage::disk('public')->delete($hotel->main_image);
        }

        $hotel->delete();

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Xóa khách sạn thành công.');
    }
}