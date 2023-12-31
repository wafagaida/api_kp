<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'image',
        'title',
        'content',
    ];

    // */
    protected $hidden = [
        // 'password',
        // 'remember_token',
        'created_at',
        'updated_at',
    ];
}
