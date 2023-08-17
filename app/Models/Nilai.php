<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'kd_mapel',
        'nilai',
    ];

    protected $hidden = [
        // 'password',
        // 'remember_token',
        'created_at',
        'updated_at',
    ];
}
