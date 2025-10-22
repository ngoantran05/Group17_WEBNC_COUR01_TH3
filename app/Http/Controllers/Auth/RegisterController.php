<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Hash; // Import thư viện mã hóa password
use Illuminate\Support\Facades\Auth; // Import thư viện xác thực
use Illuminate\Support\Facades\Validator; // Import thư viện validation
use Illuminate\Validation\Rules\Password; // Import quy tắc password

class RegisterController extends Controller
{
    /**
     * Hiển thị form đăng ký.
     */
    public function showRegistrationForm()
    {
        // Trỏ đến file view chúng ta sẽ tạo ở bước 5
        return view('auth.register'); 
    }

    /**
     * Xử lý dữ liệu đăng ký.
     */
    public function register(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        // 2. Tạo User mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // 3. Tự động đăng nhập cho user
        Auth::login($user);

        // 4. Chuyển hướng về trang chủ
        return redirect('/')->with('success', 'Đăng ký thành công!');
    }
}
