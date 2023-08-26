<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::orderBy('kd_kelas','asc')
        ->get();

        //return collection of news as a resource
        return new PostResource(true, 'List Data Kelas', $kelas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kd_kelas'  => 'required',
            'nama_kelas'=> 'required',
            'jurusan'   => 'required',
            'tingkat'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create news
        $kelas = Kelas::create([
            'kd_kelas'  => $$request->kd_kelas,
            'nama_kelas'=> $request->nama_kelas,
            'jurusan'   => $request->jurusan,
            'tingkat'   => $request->tingkat,
        ]);

        //return response
        return new PostResource(true, 'Data Kelas Berhasil Ditambahkan!', $kelas);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kelas = Kelas::where('kd_kelas',$id)
        ->get();

        return new PostResource(true, 'Data Kelas Ditemukan!', $kelas);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kd_kelas'  => 'required'. $id,
            'nama_kelas'=> 'required',
            'jurusan'   => 'required',
            'tingkat'   => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {
            $kelas = Kelas::find($id);
            if (!$kelas) {
                return response()->json(['error' => 'Data Kelas tidak ditemukan'], 404);
            }
    
            $kelas->update([
                'kd_kelas'  => $$request->kd_kelas,
                'nama_kelas'=> $request->nama_kelas,
                'jurusan'   => $request->jurusan,
                'tingkat'   => $request->tingkat,
            ]);


            return new PostResource(true, 'Data Kelas Berhasil Diubah!', $kelas);
        } catch (\Exception $e) {
            return new PostResource(false, 'Data Kelas Gagal Diubah!', [
                'details' => $e->getMessage(),
                500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        //return response
        return new PostResource(true, 'Data Kelas Berhasil Dihapus!', null);
    }
}
