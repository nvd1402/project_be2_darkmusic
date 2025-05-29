<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favourite extends Model
{
    protected $table = 'song_user_likes';

    protected $fillable = [
        'user_id' ,
        'song_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Song()
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }
}
