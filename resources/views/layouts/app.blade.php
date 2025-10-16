<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Sản phẩm & Đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="text-center mb-4">Hệ thống Quản lý</h1>
        <nav class="mb-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Sản phẩm</a>
            <a href="{{ route('orders.index') }}" class="btn btn-success">Đơn hàng</a>
        </nav>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
