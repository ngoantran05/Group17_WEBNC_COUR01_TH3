@extends('layouts.app')
@section('content')
    <div class="bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">Chào mừng đến với My Shop</h1>
            <p class="mt-6 max-w-lg mx-auto text-xl text-blue-100">Nơi tốt nhất để tìm thấy sản phẩm bạn yêu thích.</p>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-16">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-8">Danh mục Sản phẩm</h2>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}" class="bg-white px-5 py-3 rounded-full shadow-sm border border-gray-200 text-gray-700 font-medium hover:bg-gray-100 hover:shadow transition-all">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Sản phẩm Mới nhất</h2>
            <p class="mt-4 text-lg text-gray-600">Khám phá những sản phẩm vừa cập bến</p>
        </div>
        @if ($latestProducts->count() > 0)
            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @foreach ($latestProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 text-lg">Cửa hàng đang cập nhật sản phẩm.</p>
        @endif
    </div>
@endsection