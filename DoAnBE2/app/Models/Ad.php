<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'name',
        'media_type',
        'link_url',
        'is_active',
        'description'
    ];
}
