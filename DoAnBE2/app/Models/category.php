<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    // Thêm 'nhom' vào đây
    protected $fillable = ['tentheloai', 'nhom'];

    public function artists()
    {
        return $this->hasMany(Artist::class);
    }
}
