<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_jurusan',
        'nama_jurusan',
    ];

    // public function jadwal()
    // {
    //     return $this->hasMany('App\Models\Jadwal_Mapel', 'kd_jurusan');
    // }
}
