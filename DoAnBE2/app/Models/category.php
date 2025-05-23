<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'tentheloai',
        'nhom',
        'image', // thêm dòng này để có thể lưu ảnh
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Một thể loại có nhiều tin tức
    public function news()
    {
        return $this->hasMany(News::class);
    }

    // Một thể loại có nhiều nghệ sĩ (nếu có)
    public function artists()
    {
        return $this->hasMany(Artist::class);
    }

    // Một thể loại có nhiều bài hát (nếu bạn đã có bảng songs với category_id)
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
