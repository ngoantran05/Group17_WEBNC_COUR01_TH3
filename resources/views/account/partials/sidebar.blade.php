<div class="account-sidebar">
    <div class="list-group">
        <a href="{{ route('account.show') }}" 
           class="list-group-item list-group-item-action {{ $active == 'show' ? 'active' : '' }}">
           Thông tin tài khoản
        </a>
        <a href="{{ route('account.orders') }}" 
           class="list-group-item list-group-item-action {{ $active == 'orders' ? 'active' : '' }}">
           Lịch sử đơn hàng
        </a>

        {{-- Nút Đăng xuất cho di động (tùy chọn) --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="list-group-item list-group-item-action">
                Đăng xuất
            </button>
        </form>
    </div>
</div>