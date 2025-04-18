<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use HasFactory;
class Song extends Model
{
    protected $table = 'songs';

    protected $fillable = [
        'tenbaihat',
        'nghesi',
        'theloai',
        'file_amthanh',
        'anh_daidien',
    ];

}
