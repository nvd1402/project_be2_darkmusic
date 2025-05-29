<?php

return [
    'required' => ':attribute là bắt buộc.',
    'email' => ':attribute phải là email hợp lệ.',
    'unique' => ':attribute đã được sử dụng.',
    'min' => [
        'string' => ':attribute phải có ít nhất :min ký tự.',
    ],
    'max' => [
        'string' => ':attribute không được vượt quá :max ký tự.',
    ],
    'confirmed' => ':attribute xác nhận không khớp.',
    'image' => ':attribute phải là một tệp hình ảnh.',
    'mimes' => ':attribute phải có định dạng: :values.',
    
    // Các thông báo lỗi cụ thể theo tên field
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
            'confirmed' => 'Mật khẩu xác nhận không khớp.',
        ],
        'status' => [
            'required' => 'Vui lòng chọn trạng thái tài khoản.',
        ],
        'avatar' => [
            'image' => 'Vui lòng tải lên ảnh đại diện hợp lệ (JPEG, PNG).',
            'mimes' => 'Ảnh đại diện phải có định dạng JPEG hoặc PNG.',
            'max' => 'Ảnh đại diện không được vượt quá 2048 KB.',
        ],
        'tentheloai' => [
            'required' => 'Vui lòng nhập tên thể loại.',
            'max' => 'Tên thể loại không được vượt quá :max ký tự.',
            'regex' => 'Tên thể loại chỉ được chứa chữ cái, số và khoảng trắng.',
        ],
        'tieude' => [
            'required' => 'Vui lòng nhập tiêu đề.',
            'max' => 'Tiêu đề không được vượt quá :max ký tự.',
            'regex' => 'Tiêu đề chỉ được chứa chữ cái, số và khoảng trắng.',
        ],
        'noidung' => [
            'required' => 'Vui lòng nhập nội dung.',
        ],
        'donvidang' => [
            'required' => 'Vui lòng nhập đơn vị đăng.',
        ],
        'hinhanh' => [
            'image' => 'Hình ảnh phải là một tệp ảnh hợp lệ.',
            'mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'max' => 'Hình ảnh không được vượt quá :max KB.',
        ],
        'nhom' => [
            'required' => 'Vui lòng chọn nhóm thể loại.',
        ],
        'description' => [
            'required' => 'Vui lòng nhập mô tả thể loại.',
            'max' => 'Mô tả không được vượt quá :max ký tự.',
        ],
        'image' => [
            'required' => 'Vui lòng chọn hình ảnh thể loại.',
            'image' => 'Tệp tải lên phải là hình ảnh.',
            'mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'max' => 'Hình ảnh không được vượt quá :max KB.',
        ],
    ],
];
