@extends('layouts.admin')
@section('content')
<h1>Quản lý sản phẩm</h1>
<a href="{{ route('products.create') }}">Thêm sản phẩm</a>
<table>
<tr>
<th>ID</th><th>Tên</th><th>Giá</th><th>Trạng thái</th><th>Hành động</th>
</tr>
@foreach($products as $p)
<tr>
<td>{{ $p->id }}</td>
<td>{{ $p->name }}</td>
<td>{{ $p->price }}</td>
<td>{{ $p->in_stock ? 'Còn hàng' : 'Hết hàng' }}</td>
<td>
<a href="{{ route('products.edit',$p->id) }}">Sửa</a>
<form method="POST" action="{{ route('products.destroy',$p->id) }}">
@csrf @method('DELETE')
<button>Xóa</button>
</form>
</td>
</tr>
@endforeach
</table>
@endsection
