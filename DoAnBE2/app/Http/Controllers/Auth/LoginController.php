<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Validate dữ liệu
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Chống session fixation
            $request->session()->regenerate();

            // Lấy user vừa đăng nhập
            $user = Auth::user();

            // Nếu là Admin thì vào dashboard
            if ($user->role === 'Admin') {
                return redirect()->route('admin.dashboard');
            }

            // Nếu là User thì vào trang home frontend
            return redirect()->route('frontend.home');
        }

        // Nếu login thất bại
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Huỷ session và token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Quay về trang login
        return redirect()->route('login');
    }
}
