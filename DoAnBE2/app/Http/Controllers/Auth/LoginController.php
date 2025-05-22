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
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Kiểm tra trạng thái tài khoản
            if ($user->status === 'inactive') {
                Auth::logout();
                return back()->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.']);
            }

            if ($user->role === 'Admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('frontend.home');
        }

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
