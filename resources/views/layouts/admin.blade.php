<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <nav class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-5">
                <h2 class="text-xl font-bold text-center">Admin Panel</h2>
            </div>
            
            <ul class="space-y-2 px-4 flex-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 
                              {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 font-bold' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 
                              {{ request()->routeIs('admin.categories.*') ? 'bg-gray-900 font-bold' : '' }}">
                        Quản lý Danh mục
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 
                              {{ request()->routeIs('admin.products.*') ? 'bg-gray-900 font-bold' : '' }}">
                        Quản lý Sản phẩm
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 
                              {{ request()->routeIs('admin.orders.*') ? 'bg-gray-900 font-bold' : '' }}">
                        Quản lý Đơn hàng
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 
                              {{ request()->routeIs('admin.users.*') ? 'bg-gray-900 font-bold' : '' }}">
                        Quản lý Người dùng
                    </a>
                </li>
            </ul>

            <div class="p-4 border-t border-gray-700">
                <div class="mb-2">
                    <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-4 rounded transition duration-200 bg-red-600 hover:bg-red-700 text-sm">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </nav>

        <main class="flex-1 p-10 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>