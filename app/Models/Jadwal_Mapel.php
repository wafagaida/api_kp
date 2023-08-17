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
        'tingkat',
        // 'kd_jurusan',
        'kd_kelas',
    ];

    public function mapel()
    {
        return $this->belongsTo('App\Models\Mapel', 'kd_mapel', 'kd_mapel');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'kd_kelas', 'kd_kelas');
    }

    protected $hidden = [
        // 'password',
        // 'remember_token',
        'created_at',
        'updated_at',
    ];

    // protected $table = 'jadwal_mapels';
}
