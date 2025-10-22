@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm cho "' . e($query) . '"')

@push('styles')
    {{-- Tái sử dụng CSS từ trang home để hiển thị product card --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 class="my-4">
        Kết quả tìm kiếm cho: "{{ e($query) }}"
    </h1>

    @if(!$query)
        <div class="alert alert-warning text-center" role="alert">
            Vui lòng nhập từ khóa để tìm kiếm.
        </div>
    @elseif($products->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Không tìm thấy sản phẩm nào phù hợp.
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-3 col-6">
                    {{-- Tái sử dụng style .product-card từ home.css --}}
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->main_image_url ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}">
                        </a>
                        <div class="product-card-body">
                            <h5><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h5>
                            <div class="price">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-add-cart">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-5">
            {{-- Thêm withQueryString() để giữ ?query=... khi chuyển trang --}}
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection