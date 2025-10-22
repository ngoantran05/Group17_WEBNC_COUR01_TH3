<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    {{-- Link đến file CSS --}}
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    
    <div class="register-container">
        <div class="register-form-wrapper">
            
            <h2>Đăng ký</h2>

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Họ và Tên:</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận Mật khẩu:</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Số điện thoại:</label>
                    <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <textarea id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-submit">Đăng ký</button>
                    <a href="/" class="btn btn-cancel">Hủy</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>