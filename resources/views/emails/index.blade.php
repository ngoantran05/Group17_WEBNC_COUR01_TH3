@extends('layouts.app')

@section('title', 'Liên hệ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Liên hệ với chúng tôi</h1>
    <p class="text-center text-muted mb-5">
        Có câu hỏi? Gửi tin nhắn cho chúng tôi và chúng tôi sẽ phản hồi sớm nhất.
    </p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="contact-layout">
        
        <div class="contact-form">
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger p-2 small">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Chủ đề</label>
                    <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nội dung tin nhắn</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Gửi tin nhắn</button>
            </form>
        </div>

        <div class="contact-info">
            <h4>Thông tin Cửa hàng</h4>
            <p>
                <strong>Địa chỉ:</strong>
                123 Đường ABC, Phường X, Quận Y, TP. Hồ Chí Minh
            </p>
            <p>
                <strong>Điện thoại:</strong>
                <a href="tel:0987654321">0987.654.321</a>
            </p>
            <p>
                <strong>Email:</strong>
                <a href="mailto:info@shopfashion.com">info@shopfashion.com</a>
            </p>
            <p>
                <strong>Giờ làm việc:</strong>
                Thứ 2 - Chủ Nhật: 9:00 - 21:00
            </p>

            <div class="map-placeholder">
                <iframe 
                    src="https://www.google.com/maps/embed?..." 
                    width="100%" 
                    height="250" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

    </div>
</div>
@endsection