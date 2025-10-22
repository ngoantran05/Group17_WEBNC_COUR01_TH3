@extends('layouts.app')

@section('title', 'Tài khoản của tôi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 class="my-4">Tài khoản của tôi</h1>

    {{-- Hiển thị thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-3">
            @include('account.partials.sidebar', ['active' => 'show'])
        </div>

        <div class="col-md-9">
            <div class="account-content">
                <h4>Thông tin cá nhân</h4>
                <hr>
                
                <form action="{{ route('account.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                               value="{{ old('phone_number', $user->phone_number) }}" required>
                        @error('phone_number') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" 
                               value="{{ old('address', $user->address) }}" required>
                        @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <h4 class="mt-5">Đổi mật khẩu</h4>
                    <hr>
                    <p class="text-muted">Để trống nếu bạn không muốn đổi mật khẩu.</p>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        @error('new_password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection