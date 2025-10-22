<header>
    <div class="top-bar">
        <div class="container d-flex justify-content-between align-items-center">
            
            <form class="search-bar d-flex" action="{{ route('search') }}" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm..." aria-label="Search">
                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <div class="header-icons d-flex align-items-center">

                @guest
                    {{-- Nếu là Khách --}}
                    <a href="{{ route('register.form') }}" class="icon-link">
                        <i class="bi bi-person-plus"></i>
                        <span>Đăng ký</span>
                    </a>
                    <a href="{{ route('login.form') }}" class="icon-link">
                        <i class="bi bi-person"></i>
                        <span>Đăng nhập</span>
                    </a>
                @else
                    {{-- Nếu đã Đăng nhập --}}
                    <div class="nav-item dropdown">
                        <a class="icon-link dropdown-toggle" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ Str::limit(Auth::user()->name, 10) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="{{ route('account.show') }}">Tài khoản của tôi</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.orders') }}">Đơn hàng</a></li>
                            @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}">Trang Quản Trị</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest

                {{-- Giỏ hàng (Luôn hiển thị) --}}
                <a href="{{ route('cart.index') }}" class="icon-link">
                    <i class="bi bi-cart"></i>
                    <span>Giỏ hàng</span>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>

        </div>
    </div>

    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarNav" aria-controls="mainNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-center" id="mainNavbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('promotions.index') }}">Khuyến mãi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.form') }}">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>