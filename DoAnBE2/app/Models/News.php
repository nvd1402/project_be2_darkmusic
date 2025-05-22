<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Khai báo các trường cho phép gán giá trị hàng loạt
    protected $fillable = [
        'tieude',
        'noidung',
        'donvidang',
        'hinhanh',
    ];
}
