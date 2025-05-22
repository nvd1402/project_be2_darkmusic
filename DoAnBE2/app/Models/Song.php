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
        'status',
        // Bạn nên thêm các cột này vào đây nếu bạn đã tạo chúng trong migration
        // 'slug',
        // 'luotnghe',
        // 'thoiluong',
        // 'loibaihat',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'nghesi', 'id');
    }

    // Cần thêm mối quan hệ với Category nếu bạn muốn truy cập tên thể loại
    public function category()
    {
        return $this->belongsTo(Category::class, 'theloai', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
