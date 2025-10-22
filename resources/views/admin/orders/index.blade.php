@extends('layouts.admin')
@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Danh sách Đơn hàng</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Mã ĐH</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Khách hàng</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái (Cập nhật)</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Ngày đặt</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-sm text-gray-800 font-medium">#{{ $order->id }}</td>
                        <td class="py-4 px-6 text-sm text-gray-800">{{ $order->customer_name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-800">{{ number_format($order->total_amount) }} VND</td>
                        <td class="py-4 px-6 text-sm">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" 
                                        class="border border-gray-300 rounded px-2 py-1 text-sm @if($order->status == 'pending') bg-yellow-100 text-yellow-800 @elseif($order->status == 'completed') bg-green-100 text-green-800 @elseif($order->status == 'cancelled') bg-red-100 text-red-800 @else bg-blue-100 text-blue-800 @endif">
                                    <option value="pending" @if($order->status == 'pending') selected @endif>Chờ duyệt</option>
                                    <option value="processing" @if($order->status == 'processing') selected @endif>Đang xử lý</option>
                                    <option value="shipped" @if($order->status == 'shipped') selected @endif>Đang giao</option>
                                    <option value="completed" @if($order->status == 'completed') selected @endif>Hoàn thành</option>
                                    <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Đã hủy</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-4 px-6 text-sm">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Xem chi tiết</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-4 px-6 text-center text-gray-500">Chưa có đơn hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $orders->links() }}</div>
@endsection