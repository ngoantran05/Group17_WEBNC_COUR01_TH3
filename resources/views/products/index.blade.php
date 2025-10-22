@extends('layouts.app')

@section('title', 'Tất cả sản phẩm')


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endpush


@push('scripts')
    <script src="{{ asset('js/products.js') }}" defer></script>
@endpush


@section('content')
<div class="container">
    
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
        </ol>
    </nav>

    
    <form id="product-filter-form" action="{{ route('products.index') }}" method="GET">

        <div class="product-page-wrapper">
            
            
            <aside class="sidebar">
                
                
                <div class="filter-group">
                    <h5>Danh mục</h5>
                    @foreach($categories as $category)
                    <div class="filter-item">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}"
                               {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                        <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>

                
                <div class="filter-group">
                    <h5>Mức giá</h5>
                    @foreach($priceRanges as $value => $label)
                    <div class="filter-item">
                        <input type="checkbox" name="prices[]" value="{{ $value }}" id="price-{{ $value }}"
                               {{ in_array($value, request('prices', [])) ? 'checked' : '' }}>
                        <label for="price-{{ $value }}">{{ $label }}</label>
                    </div>
                    @endforeach
                </div>

                
                <div class="filter-group">
                    <h5>Loại</h5>
                    @foreach($productTypes as $type)
                    <div class="filter-item">
                        <input type="checkbox" name="types[]" value="{{ $type->id }}" id="type-{{ $type->id }}"
                               {{ in_array($type->id, request('types', [])) ? 'checked' : '' }}>
                        <label for="type-{{ $type->id }}">{{ $type->name }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="filter-group">
                    <h5>Giới tính</h5>
                    @foreach($genders as $value => $name)
                    <div class="filter-item">
                        <input type="checkbox" name="genders[]" value="{{ $value }}" id="gender-{{ $value }}"
                                {{ in_array($value, request('genders', [])) ? 'checked' : '' }}>
                        <label for="gender-{{ $value }}">{{ $name }}</label>
                    </div>
                    @endforeach
                </div>

                
                <div class="filter-group">
                    <h5>Size</h5>
                    @foreach($sizes as $size)
                    <div class="filter-item">
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}" id="size-{{ $size->id }}"
                               {{ in_array($size->id, request('sizes', [])) ? 'checked' : '' }}>
                        <label for="size-{{ $size->id }}">{{ $size->name }}</label>
                    </div>
                    @endforeach
                </div>

                
                <div class="filter-group">
                    <h5>Màu sắc</h5>
                    <div class="color-swatches">
                        @foreach($colors as $color)
                        <div class="color-swatch">
                            <input type="checkbox" name="colors[]" value="{{ $color->id }}" id="color-{{ $color->id }}"
                                   {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}>
                            <label for="color-{{ $color->id }}" 
                                      style="--color-hex: {{ $color->hex_code }}; background-color: var(--color-hex);" 
                                      title="{{ $color->name }}">
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn-filter">Lọc</button>

            </aside>

            
            <main class="main-content">
                
                
                <div class="content-header">
                    <h2>Tất cả sản phẩm</h2>
                    <div class="sort-by">
                        @php $currentSort = request('sort_by', 'moi-nhat'); @endphp
                        
                        <select name="sort_by">
                            <option value="moi-nhat" @selected($currentSort == 'moi-nhat')>Sắp xếp: Mới nhất</option>
                            <option value="gia-thap-cao" @selected($currentSort == 'gia-thap-cao')>Sắp xếp: Giá thấp đến cao</option>
                            <option value="gia-cao-thap" @selected($currentSort == 'gia-cao-thap')>Sắp xếp: Giá cao đến thấp</option>
                        </select>
                    </div>
                </div>

                
                <div class="product-grid">
                    @include('products.partials.product_grid', ['products' => $products])
                </div>

               
                <div class="pagination-container">
                    {{ $products->withQueryString()->links() }}
                </div>

            </main>
        </div>
    </form> 
</div>
@endsection
