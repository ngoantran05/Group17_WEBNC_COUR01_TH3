@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container text-center my-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Đặt hàng thành công!</h4>
        <p>Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đang được xử lý.</p>
        <hr>
        <a href="{{ route('home') }}" class="btn btn-success">Quay về Trang chủ</a>
    </div>
</div>
@endsection
