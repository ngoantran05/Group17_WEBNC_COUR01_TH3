

@forelse ($products as $product)
    <a href="{{ route('products.show', $product->slug) }}" class="product-card">
        <img src="{{ $product->main_image_url ?? 'https://via.placeholder.com/300x300.png?text=Product+Image' }}" alt="{{ $product->name }}">
        <div class="product-card-info">
            <h4>{{ $product->name }}</h4>
            <p>{{ number_format($product->price, 0, ',', '.') }}đ</p>
        </div>
    </a>
@empty
    {{-- Thêm class này để căn giữa chữ --}}
    <p style="text-align: center; grid-column: 1 / -1;">
        Không tìm thấy sản phẩm nào phù hợp với tiêu chí của bạn.
    </p>
@endforelse