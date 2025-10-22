<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel Shop') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">My Shop</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="border-transparent text-gray-700 hover:border-blue-500 hover:text-blue-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-blue-500 text-blue-600' : '' }}">Trang chủ</a>
                        <a href="{{ route('shop.index') }}" class="border-transparent text-gray-700 hover:border-blue-500 hover:text-blue-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('shop.index') || request()->routeIs('category.show') ? 'border-blue-500 text-blue-600' : '' }}">Cửa hàng</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <a href="#" class="p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="ml-4 text-sm font-medium text-gray-700 hover:text-blue-600">Đăng nhập</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm font-medium text-gray-700 hover:text-blue-600">Đăng ký</a>
                            @endif
                        @else
                            <div class="ml-3 relative">
                                @if(Auth::user()->role == 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-red-600 hover:text-red-800">Admin Panel</a>
                                @else
                                     <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">{{ Auth::user()->name }}</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-sm font-medium text-gray-700 hover:text-blue-600">Đăng xuất</a>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
        <main>
            {{ $slot ?? '' }} 
            @yield('content')
        </main>
        <footer class="bg-white border-t border-gray-200 mt-16">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-gray-500">&copy; {{ date('Y') }} My Shop. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>