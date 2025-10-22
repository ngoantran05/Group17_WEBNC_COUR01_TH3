@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="mb-12 border-b border-gray-200 pb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Cửa hàng</h1>
            <p class="mt-4 text-lg text-gray-600">Khám phá tất cả sản phẩm của chúng tôi</p>
        </div>
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-16">{{ $products->links() }}</div>
        @else
            <p class="text-center text-gray-500 text-lg">Cửa hàng đang cập nhật sản phẩm.</p>
        @endif
    </div>
@endsection