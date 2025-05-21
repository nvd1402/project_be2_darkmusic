<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_album',
        'artist_id',  // thêm artist_id vào fillable
        'anh_bia',
    ];

    // Quan hệ với Artist
    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }
}
