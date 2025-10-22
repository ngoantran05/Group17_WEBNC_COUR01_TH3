@extends('layouts.admin')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Danh sách Danh mục</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm mới</a>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Danh mục cha</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-sm text-gray-800 font-medium">{{ $category->name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-600">{{ $category->parent->name ?? '(Không có)' }}</td>
                        <td class="py-4 px-6 text-sm">
                            @if ($category->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Hoạt động</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Bị ẩn</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-xs">Sửa</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block ml-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-4 px-6 text-center text-gray-500">Không có danh mục nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection