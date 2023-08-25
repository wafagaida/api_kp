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
            'kd_kelas'     => 'required',
            'nama_kelas'     => 'required',
            'jurusan'   => 'required',
            'tingkat'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create news
        $kelas = Kelas::create([
            'kd_kelas'     => $$request->kd_kelas,
            'nama_kelas'     => $request->nama_kelas,
            'jurusan'   => $request->jurusan,
            'tingkat'   => $request->tingkat,
        ]);

        //return response
        return new PostResource(true, 'Data Kelas Berhasil Ditambahkan!', $kelas);
    }

    /**
     * Display the specified resource.
     */
    public function show($kd_kelas)
    {
        $kelas = Kelas::where('kd_kelas',$kd_kelas)
        ->get();

        return new PostResource(true, 'Data Kelas Ditemukan!', $kelas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validator = Validator::make($request->all(), [
            'kd_kelas'     => 'required',
            'nama_kelas'     => 'required',
            'jurusan'   => 'required',
            'tingkat'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if($validator) :
            $kelas->update([
                'kd_kelas'     => $request->kd_kelas,
                'nama_kelas'     => $request->nama_kelas,
                'jurusan'   => $request->jurusan,
                'tingkat'   => $request->tingkat,
            ]);


            return new PostResource(true, 'Data Kelas Berhasil Diubah!', $kelas);
        endif;
    
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $kelas = Kelas::findOrFail($id);
        //delete news
        $kelas->delete();

        //return response
        return new PostResource(true, 'Data Kelas Berhasil Dihapus!', null);
    }
}
