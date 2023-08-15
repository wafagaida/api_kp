<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kd_mapel',
        'hari',
        'jam',
        // 'jurusan',
        'kd_jurusan',
        'kelas',
    ];

    public function mapel()
    {
        return $this->belongsTo('App\Models\Mapel', 'kd_mapel', 'kd_mapel');
    }

    public function jurusan()
    {
        return $this->belongsTo('App\Models\Jurusan', 'kd_jurusan', 'kd_jurusan');
    }

    // protected $table = 'jadwal_mapels';
}
