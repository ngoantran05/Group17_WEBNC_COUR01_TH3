@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 class="my-4">Đơn hàng của tôi</h1>

    <div class="row">
        <div class="col-md-3">
            @include('account.partials.sidebar', ['active' => 'orders'])
        </div>

        <div class="col-md-9">
            <div class="account-content">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Mã ĐH</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <th scope="row">#{{ $order->id }}</th>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>{{ number_format($order->total, 0, ',', '.') }}đ</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $order->status }}</span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Xem</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Bạn chưa có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Phân trang --}}
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection