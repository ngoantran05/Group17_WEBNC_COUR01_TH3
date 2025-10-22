@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@push('styles')
<style>
    .cart-product-img { width: 100px; height: 100px; object-fit: cover; }
    .quantity-input { width: 70px; }
</style>
@endpush

@section('content')
<div class="container">
    <h1 class="my-4">Giỏ hàng của bạn</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(empty($cart))
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống. <a href="{{ route('products.index') }}">Tiếp tục mua sắm</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" colspan="2">Sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Tạm tính</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $cartId => $item)
                    <tr>
                        <td>
                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/100' }}" 
                                 alt="{{ $item['name'] }}" 
                                 class="cart-product-img rounded">
                        </td>
                        <td>
                            <a href="{{ route('products.show', $item['slug']) }}" class="text-dark text-decoration-none fw-bold">
                                {{ $item['name'] }}
                            </a>
                            <div class="text-muted small">
                                @if($item['size_name'])
                                    <span>Size: {{ $item['size_name'] }}</span>
                                @endif
                                @if($item['color_name'])
                                    <span class="ms-2">Màu: {{ $item['color_name'] }}</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                        <td>
                            <form action="{{ route('cart.update', $cartId) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control quantity-input d-inline-block">
                                <button type="submit" class="btn btn-sm btn-link p-0">Cập nhật</button>
                            </form>
                        </td>
                        <td class="fw-bold">
                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                        </td>
                        <td>
                            <form action="{{ route('cart.destroy', $cartId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">&times;</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <div class="d-flex justify-content-between my-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark">
                &larr; Tiếp tục mua hàng
            </a>
            
            <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger">
                Xóa toàn bộ giỏ hàng
            </a>
        </div>
        <div class="row justify-content-end">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng cộng</h5>
                        <h3 class="fw-bold">{{ number_format($totalPrice, 0, ',', '.') }}đ</h3>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 mt-3">Tiến hành thanh toán</a>
                        
                        </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection