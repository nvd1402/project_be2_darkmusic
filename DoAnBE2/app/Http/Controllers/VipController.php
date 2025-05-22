<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VipController extends Controller
{
    /**
     * Hiển thị form đăng ký VIP.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Điều này sẽ tải view nằm ở resources/views/frontend/vip/register.blade.php
        return view('frontend.vip');
    }
}
