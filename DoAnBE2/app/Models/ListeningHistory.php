<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeningHistory extends Model
{
    protected $table = 'listening_history'; // hoặc 'listening_histories' nếu theo convention

    protected $fillable = ['user_id', 'song_id', 'listened_at'];

    // Nếu bảng không có created_at và updated_at, thêm dòng dưới
    public $timestamps = false;

    public function song()
    {
        return $this->belongsTo(Song::class, 'song_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
