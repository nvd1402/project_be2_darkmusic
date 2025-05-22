<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeningHistory extends Model
{
    use HasFactory;

    // QUAN TRỌNG: Nếu bảng của bạn tên là 'listening_history' (số ít), hãy thêm dòng này
    // protected $table = 'listening_history';
    // Nếu bảng của bạn tên là 'listening_histories' (số nhiều), bạn CÓ THỂ bỏ qua dòng này.
    // Dựa trên lỗi 'listening_histories' doesn't exist, có thể tên bảng thực sự là số ít.
    // NÊN HÃY THỬ THÊM DÒNG NÀY ĐẦU TIÊN!
    protected $table = 'listening_history';


    protected $fillable = [
        'user_id',
        'song_id',
        'listened_at',
    ];

    /**
     * Get the user that owns the listening history.
     */
    public function user()
    {
        // 'user_id' là khóa ngoại trong bảng listening_history
        // 'user_id' là khóa chính trong bảng users (như bạn đã định nghĩa trong migration và User model)
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the song that was listened to.
     */
    public function song()
    {
        // 'song_id' là khóa ngoại trong bảng listening_history
        // 'id' là khóa chính trong bảng songs
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }
}
