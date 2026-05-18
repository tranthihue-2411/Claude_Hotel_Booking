@extends('layouts.app')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Thanh toán</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i> {{ session('info') }}
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Form thanh toán --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h2 class="text-xl font-bold text-slate-800 mb-6">Chọn phương thức thanh toán</h2>

                        <form action="{{ route('payment.process', $booking) }}" method="POST">
                            @csrf

                            <div class="space-y-3 mb-6">
                                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-4 cursor-pointer hover:border-blue-400 transition">
                                    <input type="radio" name="payment_method" value="credit_card"
                                           class="text-blue-600" checked onchange="showPaymentForm(this.value)">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">💳</span>
                                        <div>
                                            <p class="font-semibold text-slate-700">Thẻ tín dụng / Ghi nợ</p>
                                            <p class="text-xs text-slate-400">Visa, Mastercard, JCB</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-4 cursor-pointer hover:border-blue-400 transition">
                                    <input type="radio" name="payment_method" value="bank_transfer"
                                           class="text-blue-600" onchange="showPaymentForm(this.value)">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">🏦</span>
                                        <div>
                                            <p class="font-semibold text-slate-700">Chuyển khoản ngân hàng</p>
                                            <p class="text-xs text-slate-400">Vietcombank, BIDV, Techcombank...</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-4 cursor-pointer hover:border-blue-400 transition">
                                    <input type="radio" name="payment_method" value="cash"
                                           class="text-blue-600" onchange="showPaymentForm(this.value)">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">💵</span>
                                        <div>
                                            <p class="font-semibold text-slate-700">Thanh toán tại khách sạn</p>
                                            <p class="text-xs text-slate-400">Trả tiền mặt khi nhận phòng</p>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            {{-- Form thẻ --}}
                            <div id="credit_card_form" class="border border-slate-200 rounded-xl p-5 mb-6">
                                <h3 class="font-semibold mb-4 text-slate-700">Thông tin thẻ</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Tên chủ thẻ</label>
                                        <input type="text" name="card_name" value="{{ auth()->user()->name }}"
                                               placeholder="NGUYEN VAN A"
                                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Số thẻ</label>
                                        <input type="text" name="card_number"
                                               placeholder="1234 5678 9012 3456" maxlength="19"
                                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                                               oninput="formatCardNumber(this)">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Ngày hết hạn</label>
                                            <input type="text" name="card_expiry"
                                                   placeholder="MM/YY" maxlength="5"
                                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                                                   oninput="formatExpiry(this)">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">CVV</label>
                                            <input type="text" name="card_cvv"
                                                   placeholder="123" maxlength="3"
                                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-400 mt-3">🔒 Thông tin thẻ được bảo mật theo tiêu chuẩn PCI DSS</p>
                            </div>

                            {{-- Chuyển khoản --}}
                            <div id="bank_transfer_form" class="border border-slate-200 rounded-xl p-5 mb-6 hidden">
                                <h3 class="font-semibold mb-4 text-slate-700">Thông tin chuyển khoản</h3>
                                <div class="bg-slate-50 rounded-xl p-4 space-y-2 text-sm border border-slate-100">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Ngân hàng:</span>
                                        <span class="font-semibold">Vietcombank</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Số tài khoản:</span>
                                        <span class="font-semibold font-mono">1234 5678 9012</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Chủ tài khoản:</span>
                                        <span class="font-semibold">CONG TY HOTELHUB</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Nội dung CK:</span>
                                        <span class="font-semibold text-blue-600">{{ $booking->booking_reference }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Số tiền:</span>
                                        <span class="font-semibold text-blue-600">{{ number_format($booking->total_amount) }}đ</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Tiền mặt --}}
                            <div id="cash_form" class="border border-slate-200 rounded-xl p-5 mb-6 hidden">
                                <h3 class="font-semibold mb-3 text-slate-700">Thanh toán tại khách sạn</h3>
                                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                    <p class="text-amber-800 text-sm">
                                        ⚠️ Đặt phòng sẽ được giữ trong <strong>24 giờ</strong>. Vui lòng đến khách sạn và thanh toán khi nhận phòng.
                                    </p>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition text-base flex items-center justify-center gap-2">
                                <i class="fas fa-lock text-sm"></i>
                                Xác nhận thanh toán {{ number_format($booking->total_amount) }}đ
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tóm tắt --}}
                <div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-20">
                        <div class="bg-blue-600 px-6 py-5">
                            <p class="text-blue-200 text-xs font-medium mb-1">Tổng thanh toán</p>
                            <p class="text-white font-bold text-3xl">{{ number_format($booking->total_amount) }}đ</p>
                        </div>
                        <div class="p-5">
                            <img src="{{ $booking->hotel->main_image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop' }}"
                                 alt="{{ $booking->hotel->name }}"
                                 class="w-full h-28 object-cover rounded-xl mb-4">

                            <h4 class="font-bold text-slate-800 mb-1">{{ $booking->hotel->name }}</h4>
                            <p class="text-slate-400 text-xs mb-4">📍 {{ $booking->hotel->city }}</p>

                            <div class="space-y-2 text-sm mb-4 pb-4 border-b border-slate-100">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Phòng</span>
                                    <span class="font-medium text-slate-700">{{ $booking->room->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Nhận phòng</span>
                                    <span class="font-medium text-slate-700">{{ $booking->check_in_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Trả phòng</span>
                                    <span class="font-medium text-slate-700">{{ $booking->check_out_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Số đêm</span>
                                    <span class="font-medium text-slate-700">{{ $booking->number_of_nights }} đêm</span>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">{{ number_format($booking->room_price_per_night) }}đ × {{ $booking->number_of_nights }} đêm</span>
                                    <span class="text-slate-700">{{ number_format($booking->subtotal) }}đ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Thuế (10%)</span>
                                    <span class="text-slate-700">{{ number_format($booking->taxes) }}đ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Phí dịch vụ</span>
                                    <span class="text-slate-700">{{ number_format($booking->service_fee) }}đ</span>
                                </div>
                                <div class="flex justify-between font-bold text-slate-800 pt-2 border-t border-slate-100">
                                    <span>Tổng cộng</span>
                                    <span class="text-blue-600">{{ number_format($booking->total_amount) }}đ</span>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100 space-y-2">
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <i class="fas fa-shield-alt text-emerald-500"></i>
                                    <span>Thanh toán an toàn & bảo mật</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <i class="fas fa-undo text-blue-500"></i>
                                    <span>Hủy miễn phí trước ngày nhận phòng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    function showPaymentForm(method) {
        ['credit_card_form', 'bank_transfer_form', 'cash_form'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
        document.getElementById(method + '_form').classList.remove('hidden');
    }

    function formatCardNumber(input) {
        let value = input.value.replace(/\D/g, '').substring(0, 16);
        input.value = value.replace(/(.{4})/g, '$1 ').trim();
    }

    function formatExpiry(input) {
        let value = input.value.replace(/\D/g, '').substring(0, 4);
        if (value.length >= 2) value = value.substring(0, 2) + '/' + value.substring(2);
        input.value = value;
    }
    </script>
@endsection