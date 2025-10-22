@extends('layouts.admin')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Chi tiết Đơn hàng #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Quay lại danh sách</a>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Các sản phẩm trong đơn</h2>
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Sản phẩm</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Giá (lúc mua)</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-4 flex items-center">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded mr-4">
                                <span class="text-sm text-gray-800 font-medium">{{ $item->product->name }}</span>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-600">{{ number_format($item->price) }} VND</td>
                            <td class="py-4 px-4 text-sm text-gray-600">x {{ $item->quantity }}</td>
                            <td class="py-4 px-4 text-sm text-gray-800 font-medium">{{ number_format($item->price * $item->quantity) }} VND</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t"><td colspan="3" class="py-4 px-4 text-right text-gray-700 font-bold">Tổng tiền:</td>
                        <td class="py-4 px-4 text-lg text-red-600 font-bold">{{ number_format($order->total_amount) }} VND</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Trạng thái đơn hàng</h2>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Cập nhật trạng thái:</label>
                    <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="pending" @if($order->status == 'pending') selected @endif>Chờ duyệt</option>
                        <option value="processing" @if($order->status == 'processing') selected @endif>Đang xử lý</option>
                        <option value="shipped" @if($order->status == 'shipped') selected @endif>Đang giao</option>
                        <option value="completed" @if($order->status == 'completed') selected @endif>Hoàn thành</option>
                        <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Đã hủy</option>
                    </select>
                    <button type="submit" class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cập nhật</button>
                </form>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Thông tin người nhận</h2>
                <div class="space-y-2 text-gray-700">
                    <p><strong>Tên:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
                    <hr class="my-2">
                    <p><strong>Người đặt (Tài khoản):</strong> {{ $order->user->name ?? 'Khách vãng lai' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection