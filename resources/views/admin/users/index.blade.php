@extends('layouts.admin')
@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Danh sách Người dùng</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('error') }}</div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Vai trò</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Ngày tham gia</th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-sm text-gray-800 font-medium">{{ $user->name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="py-4 px-6 text-sm">
                            @if ($user->role == 'admin')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Quản trị viên</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Thành viên</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="py-4 px-6 text-sm">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-xs">Sửa</a>
                            @if (auth()->id() != $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-4 px-6 text-center text-gray-500">Không có người dùng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
@endsection