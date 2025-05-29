<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongView extends Model
{
    protected $table = 'song_views';

    protected $fillable = [
        'song_id',
        'views',
    ];

    // Nếu bạn muốn tự động cập nhật thời gian, giữ true (mặc định)
    public $timestamps = true;

    // Quan hệ ngược lại với Song (nếu cần)
    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
