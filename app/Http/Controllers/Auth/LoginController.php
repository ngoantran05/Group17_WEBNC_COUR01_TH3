<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import thư viện xác thực
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Trỏ đến file view ở bước 3
    }

    /**
     * Xử lý dữ liệu đăng nhập.
     */
    public function login(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Lấy thông tin đăng nhập
        $credentials = $request->only('email', 'password');

        // 3. Thử đăng nhập
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Nếu thành công, tạo lại session và chuyển hướng
            $request->session()->regenerate();

            return redirect()->intended('/') // Chuyển về trang chủ (hoặc trang admin)
                             ->with('success', 'Đăng nhập thành công!');
        }

        // 4. Nếu thất bại
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * (Tùy chọn) Xử lý đăng xuất.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}