@extends('layouts.app')

@section('content')
<h2>Danh sách đơn hàng</h2>
<a href="{{ route('orders.create') }}" class="btn btn-success mb-3">+ Tạo đơn hàng</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->product->name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->total_price }}₫</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
