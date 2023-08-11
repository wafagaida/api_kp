<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_mapel',
        'hari',
        'ruang',
        'jam',
        'jurusan',
        'kelas',
    ];
}
