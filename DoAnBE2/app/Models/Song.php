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

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'nghesi');
    }

    // Cần thêm mối quan hệ với Category nếu bạn muốn truy cập tên thể loại
    public function category()
    {
        return $this->belongsTo(Category::class, 'theloai');
    }
}
