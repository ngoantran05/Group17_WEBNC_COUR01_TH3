@extends('layouts.admin')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Danh sách Sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm mới</a>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Ảnh</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Danh mục</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400 text-sm">(Chưa có ảnh)</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-800 font-medium">{{ $product->name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-600">{{ $product->category->name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-800">{{ number_format($product->price) }} VND</td>
                        <td class="py-4 px-6 text-sm">
                            <form action="{{ route('admin.products.updateStatus', $product->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                    <option value="available" @if($product->status == 'available') selected @endif>Còn hàng</option>
                                    <option value="out_of_stock" @if($product->status == 'out_of_stock') selected @endif>Hết hàng</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-6 text-sm">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-xs">Sửa</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block ml-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-4 px-6 text-center text-gray-500">Không có sản phẩm nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
@endsection
