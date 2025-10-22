@extends('layouts.app')

@section('title', $product->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products-show.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/products-show.js') }}" defer></script>
@endpush


@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="py-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index', ['categories[]' => $product->category->id]) }}">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-6">
            <img src="{{ $product->main_image_url ?? 'https://via.placeholder.com/600x600.png?text=Product+Image' }}" 
                 alt="{{ $product->name }}" 
                 class="img-fluid rounded shadow-sm w-100">
        </div>

        <div class="col-lg-6">
            <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
            
            <p class="product-detail-price my-3">
                {{ number_format($product->price, 0, ',', '.') }}đ
            </p>

            <div class="mb-3">
                <h5 class="fw-bold d-inline-block me-2">Tình trạng:</h5>
                @if($product->stock > 0)
                    <span class="badge bg-success fs-6">Còn hàng ({{ $product->stock }} sản phẩm)</span>
                @else
                    <span class="badge bg-danger fs-6">Hết hàng</span>
                @endif
            </div>

            <p class="lead text-muted">{{ $product->description }}</p>

            <hr>

            <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form">
            
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if($product->sizes->isNotEmpty())
                    <div class="mb-3" id="size-group">
                        <h5 class="fw-bold">Size:</h5>
                        @foreach($product->sizes as $size)
                            <span class="size-option">
                                <input type="radio" name="size_id" value="{{ $size->id }}" id="size-{{ $size->id }}" 
                                       @if($product->stock <= 0) disabled @endif>
                                <label for="size-{{ $size->id }}">{{ $size->name }}</label>
                            </span>
                        @endforeach
                        <div class="invalid-feedback d-none mt-2" id="size-error">
                            Vui lòng chọn một size.
                        </div>
                    </div>
                @endif

                @if($product->colors->isNotEmpty())
                    <div class="mb-3" id="color-group">
                        <h5 class="fw-bold">Màu sắc:</h5>
                        @foreach($product->colors as $color)
                            <span class="color-swatch">
                                <input type="radio" name="color_id" value="{{ $color->id }}" id="color-{{ $color->id }}" 
                                       @if($product->stock <= 0) disabled @endif>
                                <label for="color-{{ $color->id }}" 
                                       style="background-color: {{ $color->hex_code }};" 
                                       title="{{ $color->name }}">
                                </label>
                            </span>
                        @endforeach
                        <div class="invalid-feedback d-none mt-2" id="color-error">
                            Vui lòng chọn một màu.
                        </div>
                    </div>
                @endif

                {{-- Lựa chọn Số lượng --}}
                <div class="mb-3">
                    <label for="quantity" class="form-label fw-bold">Số lượng:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" 
                           value="1" min="1" max="{{ $product->stock }}" 
                           style="width: 100px;" 
                           @if($product->stock <= 0) disabled @endif>
                </div>

                {{-- Nhóm các nút bấm --}}
                <div class="d-flex gap-3 mt-4">
                    @if($product->stock > 0)
                        {{-- 1. Nút Thêm vào giỏ hàng --}}
                        <button type="submit" class="btn btn-outline-primary btn-lg" style="flex-grow: 1; padding: 15px;">
                            Thêm vào giỏ hàng
                        </button>
                        
                        {{-- 2. Nút Mua ngay (dùng formaction) --}}
                        <button type="submit" class="btn btn-primary btn-lg" style="flex-grow: 1; padding: 15px;"
                                >
                            Mua ngay
                        </button>
                    @else
                        {{-- Nút khi hết hàng --}}
                        <button type="button" class="btn btn-secondary btn-lg" style="flex-grow: 1; padding: 15px;" disabled>
                            Đã hết hàng
                        </button>
                    @endif
                </div>
            </form>

        </div>
    </div>

    {{-- 3. Sản phẩm liên quan --}}
    <hr class="my-5">
    <div class="related-products">
        <h2 class="text-center mb-4">Sản phẩm liên quan</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            
            @forelse ($relatedProducts as $related)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <a href="{{ route('products.show', $related->slug) }}">
                            <img src="{{ $related->main_image_url ?? 'https://via.placeholder.com/300x300.png?text=Product+Image' }}" 
                                 class="card-img-top" 
                                 alt="{{ $related->name }}"
                                 style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <a href="{{ route('products.show', $related->slug) }}" class="text-dark text-decoration-none">
                                    {{ $related->name }}
                                </a>
                            </h5>
                            <p class="card-text text-danger fw-bold">
                                {{ number_format($related->price, 0, ',', '.') }}đ
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Không có sản phẩm liên quan.</p>
            @endforelse

        </div>
    </div>
</div>
@endsection