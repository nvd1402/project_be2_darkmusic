<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Userss extends Authenticatable
{
    use Notifiable;

    // Tên bảng
    protected $table = 'users';

    // Khóa chính
    protected $primaryKey = 'user_id';

    // Nếu cần, xác định kiểu và auto-increment
    public $incrementing = true;
    protected $keyType = 'int';

    // Tạo cho Auth đúng key name
    public function getKeyName()
    {
        return 'user_id';
    }

    // Đảm bảo Auth cũng dùng đúng cột khi login()
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    // Các cột có thể fill
    protected $fillable = [
        'username',
        'email',
        'password',
        'status',
        'role',
        'avatar',
    ];

    // Ẩn khi toArray/toJson
    protected $hidden = [
        'password',
        'remember_token',
    ];
}

