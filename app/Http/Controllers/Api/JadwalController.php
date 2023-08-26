<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Jadwal_Mapel;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index()
    {

        $jadwal = Jadwal_Mapel::orderBy('kd_kelas', 'asc')->orderBy('hari','desc')->orderBy('jam', 'asc')
        ->with(['mapel', 'kelas'])
        ->get();

        //return collection of news as a resource
        return new PostResource(true, 'List Mapel', $jadwal);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kd_mapel' => 'required',
            'hari'     => 'required',
            'jam'      => 'required',
            'kd_kelas'  => 'required',
            'tingkat'  => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ], 422);
        }

        //create news
        $jadwal = Jadwal_Mapel::create([
            'kd_mapel' => $request->kd_mapel,
            'hari'     => $request->hari,
            'jam'      => $request->jam,
            'kd_kelas' => $request->kd_kelas,
            'tingkat'  => $request->tingkat,
        ]);

        //return response
        return new PostResource(true, 'Data Mapel Berhasil Ditambahkan!', $jadwal);
    }

    public function show($id)
    {
        $jadwal = Jadwal_Mapel::where('kd_kelas',$id)
        ->with(['mapel', 'kelas'])
        ->get();
        $kd_kelas = $jadwal->groupBy('kd_kelas');
        // $jadwal = Jadwal_Mapel::with(['mapel', 'jurusan'])->get();
        return new PostResource(true, 'Data Mapel Ditemukan!', $jadwal);
        
    }
    

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kd_mapel' => 'required',
            'hari'     => 'required',
            'jam'      => 'required',
            'kd_kelas'  => 'required',
            'tingkat'  => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {
            $jadwal = Jadwal_Mapel::find($id);
            if (!$jadwal) {
                return response()->json(['error' => 'Data Jadwal Mapel tidak ditemukan'], 404);
            }
    
            $jadwal->update([
                'kd_mapel' => $request->kd_mapel,
                'hari'     => $request->hari,
                'jam'      => $request->jam,
                'kd_kelas' => $request->kd_kelas,
                'tingkat'  => $request->tingkat,
            ]);


            return new PostResource(true, 'Data Jadwal Mapel Berhasil Diubah!', $jadwal);
        } catch (\Exception $e) {
            return new PostResource(false, 'Data Jadwal Mapel Gagal Diubah!', [
                'details' => $e->getMessage(),
                500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $jadwal = Jadwal_Mapel::findorfail($id);
        $jadwal->delete();

        //return response
        return new PostResource(true, 'Data Mapel Berhasil Dihapus!', null);
    }
}
