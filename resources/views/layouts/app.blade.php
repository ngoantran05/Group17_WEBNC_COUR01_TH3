<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Tiêu đề trang sẽ được lấy từ @section('title') của các trang con --}}
    <title>@yield('title', 'ShopFashion')</title>

    {{-- Link Bootstrap CSS (Dùng chung cho toàn trang) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- Nơi này để nạp các file CSS riêng của từng trang (ví dụ: products.css) --}}
    @stack('styles')
</head>
<body>
    @include('layouts.partials.header')
    <main class="py-4">
        @yield('content')
    </main>
    @include('layouts.partials.footer')
    

    {{-- Link Bootstrap JS (Dùng chung cho toàn trang) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    {{-- Nơi này để nạp các file JS riêng của từng trang (ví dụ: products.js) --}}
    @stack('scripts')

</body>
</html>