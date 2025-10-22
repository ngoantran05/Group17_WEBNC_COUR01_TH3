@extends('layouts.app')
@section('content')
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Trang chủ</a></li>
                    <li><svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg></li>
                    <li><a href="{{ route('category.show', $product->category->slug) }}" class="text-gray-500 hover:text-gray-700">{{ $product->category->name }}</a></li>
                </ol>
            </nav>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-lg shadow-lg">
                    @else
                        <div class="w-full aspect-square flex items-center justify-center bg-gray-100 rounded-lg shadow-lg"><span class="text-gray-400">No Image</span></div>
                    @endif
                </div>
                <div>
                    <a href="{{ route('category.show', $product->category->slug) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">{{ $product->category->name }}</a>
                    <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight">{{ $product->name }}</h1>
                    <p class="mt-4 text-4xl font-bold text-red-600">{{ number_format($product->price) }} VND</p>
                    <form class="mt-8">
                        @csrf
                        <div class="mb-4">
                            <label for="quantity" class="text-sm font-medium text-gray-700">Số lượng:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="mt-1 w-20 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors duration-300">Thêm vào Giỏ hàng</button>
                    </form>
                    <div class="mt-10">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Mô tả sản phẩm</h2>
                        <div class="text-gray-700 space-y-4 prose">{!! nl2br(e($product->description)) !!}</div>
                    </div>
                </div>
            </div>
            @if($relatedProducts->count() > 0)
                <div class="mt-24">
                    <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">Sản phẩm liên quan</h2>
                    <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                        @foreach ($relatedProducts as $related)
                            <x-product-card :product="$related" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection