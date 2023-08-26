<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Nilai;

class NilaiController extends Controller
{
    public function index(){

        $nilai = Nilai::orderBy('semester','asc')->orderBy('nis', 'asc')
        ->with(['mapel', 'user'])
        ->get();
        

        //return collection of news as a resource
        return new PostResource(true, 'List Nilai', $nilai);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nis'        => 'required',
            'kd_mapel'   => 'required',
            'nilai'      => '',
            'semester'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create news
        $nilai = Nilai::create([
            'nis'        => $request->nis,
            'kd_mapel'   => $request->kd_mapel,
            'nilai'      => $request->nilai,
            'semester'   => $request->semester,
        ]);

        //return response
        return new PostResource(true, 'Data Nilai Siswa Berhasil Ditambahkan!', $nilai);
    }

    public function show($id)
    {
        $nilai = Nilai::where('nis',$id)
        ->with(['mapel', 'user'])
        ->get();
        $kd_mapel = $nilai->groupBy('kd_mapel');

        return new PostResource(true, 'Data Nilai Siswa Ditemukan!', $nilai);
        
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nis'        => 'required',
            'kd_mapel'   => 'required',
            'nilai'      => 'required',
            'semester'   => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {
            $nilai = Nilai::find($id);
            if (!$nilai) {
                return response()->json(['error' => 'Data Nilai Siswa tidak ditemukan'], 404);
            }
    
            $nilai->update([
                'nis'        => $request->nis,
                'kd_mapel'   => $request->kd_mapel,
                'nilai'      => $request->nilai,
                'semester'   => $request->semester,
            ]);


            return new PostResource(true, 'Data Nilai Siswa Berhasil Diubah!', $nilai);
        } catch (\Exception $e) {
            return new PostResource(false, 'Data Nilai Siswa Gagal Diubah!', [
                'details' => $e->getMessage(),
                500
            ]);
        }
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);

        $nilai->delete();

        return new PostResource(true, 'Data Nilai Siswa Berhasil Dihapus!', null);
    }
}
