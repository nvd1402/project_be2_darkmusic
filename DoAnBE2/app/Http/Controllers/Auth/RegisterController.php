<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userss;            // Model User mặc định của Laravel
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Hiển thị form đăng ký
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký
     */
    public function register(Request $request)
    {
        // Validate dữ liệu
        $data = $request->validate([
            'email'                 => 'required|email|unique:users,email',
            'username'              => 'required|string|max:255|unique:users,username',
            'password'              => 'required|confirmed|min:8',
        ]);

        // Tạo user mới
        $user = Userss::create([
            'email'     => $data['email'],
            'username'  => $data['username'],
            'password'  => Hash::make($data['password']),
        ]);

        // Đăng nhập tự động
        Auth::login($user);

        // Chuyển hướng về trang chủ hoặc trang mong muốn
        return redirect()->intended('/');
    }
}
