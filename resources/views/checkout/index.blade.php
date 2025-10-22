@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/checkout.js') }}" defer></script>
@endpush

@section('content')
<div class="container checkout-page">
    <h1 class="my-4 text-center">Thanh toán Đơn hàng</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Đã xảy ra lỗi!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf
        <div class="checkout-layout">
            
            <div class="checkout-box">
                <h4 class="box-title">Thông tin người nhận</h4>
                <div class="form-group">
                    <label for="name">Họ và Tên</label>
                    <input type="text" name="name" id="name" value="{{ $user->name ?? old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email ?? old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" name="phone" id="phone" value="{{ $user->phone_number ?? old('phone') }}" required>
                </div>

                <h4 class="box-title mt-4">Địa chỉ giao hàng</h4>
                
                <div class="form-group">
                    <label for="province-select">Tỉnh/Thành phố</label>
                    <select name="province" id="province-select" class="form-select" required>
                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="district-select">Quận/Huyện</label>
                    <select name="district" id="district-select" class="form-select" required>
                        <option value="">-- Chọn Quận/Huyện --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ward-select">Phường/Xã</label>
                    <select name="ward" id="ward-select" class="form-select" required>
                        <option value="">-- Chọn Phường/Xã --</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address">Số nhà, tên đường</label>
                    <input type="text" name="address" id="address" value="{{ $user->address ?? old('address') }}" required>
                </div>
                <div class="form-group">
                    <label for="note">Ghi chú (Tùy chọn)</label>
                    <textarea name="note" id="note" rows="3">{{ old('note') }}</textarea>
                </div>
            </div>

            <div class="checkout-box">
                <h4 class="box-title">Phương thức thanh toán</h4>
                <div class="payment-method">
                    <input type="radio" name="payment_method" id="cod" value="cod" checked>
                    <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="payment-method">
                    <input type="radio" name="payment_method" id="bank" value="bank">
                    <label for="bank">Chuyển khoản ngân hàng</label>
                </div>
            </div>

            <div class="checkout-box">
                <h4 class="box-title">Đơn hàng</h4>
                
                <div class="order-summary">
                    @foreach($cart as $item)
                    <div class="summary-item">
                        <span class="item-name">{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                        <span class="item-price">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="summary-item">
                        <span>Tạm tính</span>
                        <span class="fw-bold" id="subtotal-display">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="summary-item">
                        <span>Phí vận chuyển</span>
                        <span class="fw-bold" id="shipping-display">{{ number_format($shippingFee, 0, ',', '.') }}đ</span>
                    </div>
                    <hr>
                    <div class="summary-item total">
                        <span class="fw-bold">Tổng cộng</span>
                        <span class="fw-bold fs-5" id="total-display">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <input type="text" name="discount_code" placeholder="Mã giảm giá" id="discount-code-input">
                    <button type="button" class="btn btn-secondary" id="apply-discount-btn">Áp dụng</button>
                    <div id="discount-message" class="mt-2 small"></div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mt-3">Hoàn tất đơn hàng</button>
            </div>

        </div>
    </form>
</div>
@endsection
