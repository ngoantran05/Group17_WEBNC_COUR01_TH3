@extends('layouts.app')

@section('title', 'Trang chủ')

{{-- Nạp các file CSS cần thiết --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/promotions.css') }}"> {{-- Tái sử dụng CSS Khuyến mãi --}}
@endpush

{{-- Nạp JS cho nút "Copy" khuyến mãi --}}
@push('scripts')
    <script src="{{ asset('js/promotions.js') }}" defer></script>
@endpush

@section('content')

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>Build Your Signature Look</h1>
            <p class="lead">Start with the Foundation.</p>
        </div>
    </div>
</section>

<section class="container my-5">
    <h2 class="text-center mb-4" style="font-weight: 700;">Danh mục nổi bật</h2>
    <div class="row g-4">
        @foreach($featuredCategories as $category)
            <div class="col-md-3 col-6">
                <a href="{{ route('products.index', ['categories[]' => $category->id]) }}" class="category-card">
                    {{-- LƯU Ý: Bạn cần tự thêm ảnh cho danh mục, ví dụ: /images/cat_ao.jpg --}}
                    <img src="{{ asset('images/cat_' . $category->slug . '.jpg') }}" alt="{{ $category->name }}">
                    <div class="category-card-title">{{ $category->name }}</div>
                </a>
            </div>
        @endforeach
    </div>
</section>

<section class="product-section">
    <div class="container">
        <h2 class="text-center mb-4" style="font-weight: 700;">Sản phẩm nổi bật</h2>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-md-3 col-6">
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
    </div>
</section>

<section class="deal-banner my-5">
    <h3><i class="bi bi-star-fill"></i> Ưu đãi trong tuần</h3>
    <p class="lead">Giảm đến 50% cho toàn bộ sản phẩm Thu Đông!</p>
    <a href="{{ route('promotions.index') }}" class="btn btn-dark btn-lg">Mua ngay</a>
</section>

<section class="container my-5">
    <h2 class="text-center mb-4" style="font-weight: 700;">Khuyến mãi & Ưu đãi</h2>
    <div class="row g-4">
        @forelse ($promotions as $promo)
            <div class="col-md-4">
                <div class="promo-card h-100">
                    <div class="promo-card-body">
                        <h5 class="promo-card-title">
                            @if($promo->type == 'percent')
                                Giảm {{ $promo->value }}%
                            @else
                                Giảm {{ number_format($promo->value, 0, ',', '.') }}đ
                            @endif
                        </h5>
                        <p class="promo-card-description">Sử dụng mã bên dưới khi thanh toán:</p>
                        <div class="promo-code-wrapper">
                            <span class="promo-code" id="home-code-{{ $promo->id }}">{{ $promo->code }}</span>
                            <button class="btn-copy-code btn btn-primary btn-sm" data-clipboard-target="#home-code-{{ $promo->id }}">
                                Sao chép
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p class="text-center text-muted">Hiện chưa có chương trình khuyến mãi nào.</p>
            </div>
        @endforelse
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('promotions.index') }}" class="btn btn-outline-dark">Xem tất cả khuyến mãi</a>
    </div>
</section>

@endsection