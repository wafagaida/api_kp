<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_mapel',
        'nama_mapel',
        'nama_guru',
        // 'kkm',
    ];

    public function jadwal()
    {
        return $this->hasMany('App\Models\Jadwal_Mapel', 'kd_mapel');
    }
}
