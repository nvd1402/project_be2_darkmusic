<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Khai báo tên bảng nếu không theo quy ước Laravel
    protected $table = 'categories';

    // Các trường cho phép gán giá trị hàng loạt
    protected $fillable = [
        'tentheloai',
        'nhom',
    ];

    // Nếu bạn muốn khai báo các trường ngày tháng (mặc định Laravel đã tự hiểu)
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Quan hệ: 1 category có nhiều news (nếu có trường category_id hoặc theo logic của bạn)
    // Nếu bảng news không có category_id thì bỏ phần này
    public function news()
    {
        return $this->hasMany(News::class);
    }

}
