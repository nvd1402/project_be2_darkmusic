<?php

return [
    'required' => ':attribute là bắt buộc.',
    'email' => ':attribute phải là email hợp lệ.',
    'unique' => ':attribute đã được sử dụng.',
    'min' => [
        'string' => ':attribute phải có ít nhất :min ký tự.',
    ],
    'confirmed' => ':attribute xác nhận không khớp.',

    // Các thông báo lỗi khác
    'custom' => [
        'username' => [
            'required' => 'Vui lòng nhập họ tên hợp lệ.',
            'regex' => 'Họ tên không được chứa ký tự đặc biệt và số.',
        ],
        'email' => [
            'required' => 'Email là bắt buộc.',
            'email' => 'Email không hợp lệ.',
            'unique' => 'Email này đã được sử dụng.',
        ],
        'password' => [
            'required' => 'Mật khẩu là bắt buộc.',
            'min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ],
        'password_confirmation' => [
            'confirmed' => 'Mật khẩu không khớp.',
        ],
        'status' => [
            'required' => 'Vui lòng chọn trạng thái tài khoản.',
        ],
        'avatar' => [
            'nullable' => 'Ảnh đại diện là không bắt buộc.',
            'image' => 'Vui lòng tải lên ảnh đại diện hợp lệ (JPEG, PNG, <= 1 MB).',
            'mimes' => 'Ảnh đại diện phải có định dạng JPEG hoặc PNG.',
            'max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ],
    ],
];
