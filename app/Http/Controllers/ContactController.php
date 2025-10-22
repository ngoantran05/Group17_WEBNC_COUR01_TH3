<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
use App\Mail\ContactFormMail; 
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact.index');
    }

    public function submitForm(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            Mail::to('maihuythnh204@gmail.com')->send(new ContactFormMail($data));
            return redirect()->route('contact.form')
                             ->with('success', 'Cảm ơn bạn! Tin nhắn của bạn đã được gửi thành công.');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Lỗi! Không thể gửi tin nhắn. Vui lòng thử lại sau.')
                             ->withInput();
        }
    }
}
