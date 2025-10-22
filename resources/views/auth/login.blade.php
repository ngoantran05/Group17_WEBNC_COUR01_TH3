<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-container">
        <div class="login-form-wrapper">

            <h2>Đăng nhập</h2>

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div classs="form-helper">
                    <a href="#" class="forgot-password">Quên mật khẩu?</a>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-submit">Đăng nhập</button>
                </div>

                <div class="register-link">
                    Chưa có tài khoản? <a href="{{ route('register.form') }}">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>