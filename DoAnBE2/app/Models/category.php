<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    // Các trường được phép gán hàng loạt
    protected $fillable = [
        'tentheloai',
        'nhom',
        'description',
        'status',  // trạng thái hoạt động (true/false)
        'image',
    ];

    // Tự động cast kiểu dữ liệu
    protected $casts = [
        'status' => 'boolean',
    ];

    // Các trường ngày giờ (Laravel tự nhận nhưng khai báo cho rõ)
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Quan hệ: Một thể loại có nhiều tin tức
    public function news()
    {
        return $this->hasMany(News::class);
    }

    // Quan hệ: Một thể loại có nhiều nghệ sĩ
    public function artists()
    {
        return $this->hasMany(Artist::class);
    }

    // Quan hệ: Một thể loại có nhiều bài hát
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
    public function artist()
{
    return $this->belongsTo(Artist::class, 'nghesi');
}

}
