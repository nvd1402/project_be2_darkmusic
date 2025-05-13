<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'name',
        'content',
        'media_type',
        'link_url',
        'is_active',
        'description'
    ];
}
