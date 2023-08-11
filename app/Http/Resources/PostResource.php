<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public $status;
    public $message;
    
    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $message, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'success'   => $this->status,
            'message'   => $this->message,
            'data'      => $this->resource,
        ];
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
    //     return [
    //         'id' => $this->id,
    //         'nis' => $this->nis,
    //         'nik' => $this->nik,
    //         'username' => $this->username,
    //         'password' => $this->password,
    //         'nama' => $this->nama,
    //         'jenis_kelamin' => $this->jenis_kelamin,
    //         'tanggal_lahir' => $this->tanggal_lahir,
    //         'alamat' => $this->alamat,
    //         'kelas' => $this->kelas,
    //         'jurusan' => $this->jurusan,
    //         'no_tlp' => $this->no_tlp,
    //         'tahun_masuk' => $this->tahun_masuk,
    //         'created_at' => $this->created_at,
    //         'updated_at' => $this->updated_at,
    //     ];
    // }
}
