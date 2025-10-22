@extends('layouts.app')

@section('title', 'Chương trình Khuyến mãi')

{{-- Nạp file CSS và JS cho trang này --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/promotions.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/promotions.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Khuyến mãi</li>
        </ol>
    </nav>
    <h1 class="my-4 text-center">Chương trình Khuyến mãi</h1>
    <p class="text-center text-muted mb-5">
        Sử dụng mã giảm giá dưới đây để nhận được ưu đãi tốt nhất!
    </p>

    {{-- Lưới hiển thị các thẻ khuyến mãi --}}
    <div class="promotion-grid">
        @forelse ($promotions as $promo)
            <div class="promo-card">
                <div class="promo-card-body">
                    <h5 class="promo-card-title">
                        @if($promo->type == 'percent')
                            Giảm {{ $promo->value }}%
                        @else
                            Giảm {{ number_format($promo->value, 0, ',', '.') }}đ
                        @endif
                    </h5>
                    <p class="promo-card-description">
                        @if($promo->type == 'percent')
                            Giảm {{ $promo->value }}% cho toàn bộ đơn hàng.
                        @else
                            Giảm ngay {{ number_format($promo->value, 0, ',', '.') }}đ cho đơn hàng của bạn.
                        @endif
                    </p>
                    
                    <div class="promo-code-wrapper">
                        <span class="promo-code" id="code-{{ $promo->id }}">{{ $promo->code }}</span>
                        {{-- Nút Copy (sẽ được xử lý bằng JS) --}}
                        <button class="btn-copy-code" data-clipboard-target="#code-{{ $promo->id }}">
                            Sao chép
                        </button>
                    </div>
                </div>
                <div class="promo-card-footer">
                    @if($promo->expires_at)
                        HSD: {{ $promo->expires_at->format('d/m/Y') }}
                    @else
                        Không thời hạn
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-info w-100 text-center">
                Hiện tại không có chương trình khuyến mãi nào.
            </div>
        @endforelse
    </div>

</div>
@endsection