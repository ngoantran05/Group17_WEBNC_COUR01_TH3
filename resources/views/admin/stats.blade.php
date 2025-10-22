@extends('layouts.admin')
@section('content')
<h1>Thống kê doanh thu</h1>
<p>Tổng đơn hàng: {{ $ordersCount }}</p>
<p>Doanh thu: {{ $totalRevenue }} VND</p>
@endsection
