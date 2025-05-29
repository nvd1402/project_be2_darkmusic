<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';

    protected $fillable = [
        'tenbaihat',
        'nghesi',
        'theloai',
        'file_amthanh',
        'anh_daidien',
        // Nếu bạn dùng các trường này, hãy chắc là đã tạo trong migration
        // 'slug',
        // 'luotnghe',
        // 'thoiluong',
        // 'loibaihat',
    ];

    // Quan hệ với nghệ sĩ (Artist)
    public function artist()
    {
        return $this->belongsTo(Artist::class, 'nghesi', 'id');
    }

    // Quan hệ với thể loại (Category)
    public function category()
    {
        return $this->belongsTo(Category::class, 'theloai', 'id');
    }
    
    // Quan hệ nhiều-nhiều với người dùng thích bài hát
    public function likedByUsers()
    {
        return $this->belongsToMany(
            Userss::class,
            'song_user_likes',
            'song_id',
            'user_id'
        );
    }

    // Quan hệ 1-1 với bảng song_views
public function songView()
{
    return $this->hasOne(SongView::class);
}

    // Thuộc tính truy cập lượt view, trả về 0 nếu chưa có bản ghi song_view
    public function getViewCountAttribute()
    {
        return $this->view ? $this->view->views : 0;
    }
}
