<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\Order; // Cần import Order

class AccountController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('account.show', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],

            'current_password' => [
                'nullable',
                'required_with:new_password',
                function ($attribute, $value, $fail) use ($user) {
                    if ($value && !Hash::check($value, $user->password)) {
                        $fail('Mật khẩu hiện tại không chính xác.');
                    }
                },
            ],
            'new_password' => [
                'nullable',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('account.show')->with('success', 'Cập nhật thông tin thành công!');
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10); 

        return view('account.orders', compact('orders'));
    }
}