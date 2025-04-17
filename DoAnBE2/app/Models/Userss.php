<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userss extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id','username', 'password', 'email', 'status', 'role', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
