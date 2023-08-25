<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bayar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nis',
        'nama_bayar',
        'bulan',
        'semester',
        'nominal',
        'jumlah_bayar',
        'tgl_bayar',
        'ket',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'nis', 'nis');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
