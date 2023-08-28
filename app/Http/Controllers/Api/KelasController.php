<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('tingkat', 'asc')->orderBy('kd_kelas', 'asc')
        ->get();

        return new PostResource(true, 'List Data Kelas', $kelas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kd_kelas' => 'required',
            'nama_kelas' => 'required',
            'jurusan' => 'required',
            'tingkat' => 'required',
        ]);

        if ($validator->fails()) {
            return new PostResource(false, 'Validasi Gagal', [
                'errors' => $validator->errors(),
            ]);
        }

        $kelas = Kelas::create([
            'kd_kelas' => $request->kd_kelas,
            'nama_kelas' => $request->nama_kelas,
            'jurusan' => $request->jurusan,
            'tingkat' => $request->tingkat,
        ]);

        return new PostResource(true, 'Data Kelas Berhasil Ditambahkan!', $kelas);
    }

    public function show($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return new PostResource(false, 'Data Kelas Tidak Ditemukan!', null);
        }

        return new PostResource(true, 'Data Kelas Ditemukan!', $kelas);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kd_kelas' => 'required',
            'nama_kelas' => 'required',
            'jurusan' => 'required',
            'tingkat' => 'required',
        ]);

        if ($validator->fails()) {
            return new PostResource(false, 'Validasi Gagal', [
                'errors' => $validator->errors(),
            ]);
        }

        $kelas = Kelas::find($id);

        if (!$kelas) {
            return new PostResource(false, 'Data Kelas Tidak Ditemukan!', null);
        }

        $kelas->update([
            'kd_kelas' => $request->kd_kelas,
            'nama_kelas' => $request->nama_kelas,
            'jurusan' => $request->jurusan,
            'tingkat' => $request->tingkat,
        ]);

        return new PostResource(true, 'Data Kelas Berhasil Diubah!', $kelas);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);

        $kelas->delete();

        return new PostResource(true, 'Data Kelas Berhasil Dihapus!', null);
    }
}
