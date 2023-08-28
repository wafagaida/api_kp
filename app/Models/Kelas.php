<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    // protected $primaryKey = 'kd_kelas';

    protected $fillable = [
        'kd_kelas',
        'nama_kelas',
        'jurusan',
        'tingkat',
    ];

    public function jadwal()
    {
        return $this->belongsTo('App\Models\Jadwal_Mapel', 'kd_kelas');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'kd_kelas');
    }
}
