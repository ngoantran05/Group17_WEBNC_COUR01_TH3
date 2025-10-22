@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Bảng điều khiển (Dashboard)</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500">Tổng Doanh Thu</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($totalRevenue) }} VND</p>
            <small class="text-gray-400">(Đơn đã hoàn thành)</small>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500">Doanh thu tháng này</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($monthRevenue) }} VND</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500">Tổng Đơn hàng</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalOrders }}</p>
            <p class="text-sm text-yellow-600 mt-1">Chờ duyệt: {{ $pendingOrders }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-sm font-medium text-gray-500">Tổng Khách hàng</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCustomers }}</p>
            <small class="text-gray-400">(Không tính Admin)</small>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4 text-gray-700">5 Đơn hàng mới nhất</h2>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Mã ĐH</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Khách hàng</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Ngày đặt</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($latestOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-sm text-gray-800">#{{ $order->id }}</td>
                        <td class="py-4 px-6 text-sm text-gray-800">{{ $order->customer_name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-800">{{ number_format($order->total_amount) }} VND</td>
                        <td class="py-4 px-6 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($order->status == 'completed') bg-green-100 text-green-800 
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-4 px-6 text-sm">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Xem</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 px-6 text-center text-gray-500">Chưa có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection