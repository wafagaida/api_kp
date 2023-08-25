<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nis',
        'kd_mapel',
        'nilai',
        'semester',
    ];

    public function mapel()
    {
        return $this->belongsTo('App\Models\Mapel', 'kd_mapel', 'kd_mapel');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'nis', 'nis');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
