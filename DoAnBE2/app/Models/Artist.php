<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artists';
    protected $primaryKey = 'id';
    protected $fillable  = [
        'name_artist',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
