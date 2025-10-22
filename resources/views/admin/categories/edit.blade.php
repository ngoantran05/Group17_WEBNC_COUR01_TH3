@extends('layouts.admin')
@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Sửa Danh mục: {{ $category->name }}</h1>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Rất tiếc, đã có lỗi!</strong>
                <ul class="mt-2 list-disc ml-5">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="parent_id" class="block text-gray-700 text-sm font-bold mb-2">Danh mục cha:</label>
                <select id="parent_id" name="parent_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">-- (Không có) --</option>
                    @foreach ($parentCategories as $parent)
                        <option value="{{ $parent->id }}" @if(old('parent_id', $category->parent_id) == $parent->id) selected @endif>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả:</label>
                <textarea id="description" name="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="mb-4">
                <label for="order" class="block text-gray-700 text-sm font-bold mb-2">Thứ tự sắp xếp:</label>
                <input type="number" id="order" name="order" value="{{ old('order', $category->order) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="is_active" class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" class="mr-2" @if(old('is_active', $category->is_active)) checked @endif>
                    <span class="text-gray-700 text-sm font-bold">Kích hoạt danh mục</span>
                </label>
            </div>
            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection