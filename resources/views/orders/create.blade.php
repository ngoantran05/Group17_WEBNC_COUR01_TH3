@extends('layouts.app')

@section('content')
<h2>Tạo đơn hàng mới</h2>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Tên khách hàng</label>
        <input type="text" name="customer_name" class="form-control">
    </div>

    <div class="mb-3">
        <label>Sản phẩm</label>
        <select name="product_id" class="form-control">
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->price }}₫)</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Số lượng</label>
        <input type="number" name="quantity" class="form-control">
    </div>

    <button class="btn btn-success">Tạo đơn</button>
</form>
@endsection
