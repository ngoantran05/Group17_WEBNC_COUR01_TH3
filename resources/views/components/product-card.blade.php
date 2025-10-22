@props(['product'])
<div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300">
    <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
        <a href="{{ route('product.show', $product->slug) }}">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover group-hover:opacity-75 transition-opacity duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-100"><span class="text-gray-400">No Image</span></div>
            @endif
        </a>
    </div>
    <div class="p-4">
        <h3 class="text-sm text-gray-500">
            <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
        </h3>
        <h2 class="mt-1 text-lg font-medium text-gray-900 truncate">
            <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}" class="hover:text-blue-600">{{ $product->name }}</a>
        </h2>
        <p class="mt-2 text-xl font-bold text-red-600">{{ number_format($product->price) }} VND</p>
        <a href="{{ route('product.show', $product->slug) }}" class="mt-4 w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Xem chi tiết</a>
    </div>
</div>