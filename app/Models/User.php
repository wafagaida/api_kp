<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $table = 'users';

    protected $fillable = [
        'nis',
        'nik',
        'username',
        'password',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'tingkat',
        'kd_kelas',
        'jurusan',
        'no_tlp',
        'tahun_masuk',
    ];

    // public function kelas()
    // {
    //     return $this->hasMany('App\Models\Kelas', 'kd_kelas', 'kd_kelas');
    // }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'kd_kelas', 'kd_kelas');
    }

    public function nilai()
    {
        return $this->belongsTo('App\Models\Nilai', 'nis');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    protected $primaryKey = 'username';
}
