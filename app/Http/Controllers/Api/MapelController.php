<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = Mapel::orderBy('kd_mapel','asc')
        ->get();

        //return collection of news as a resource
        return new PostResource(true, 'List Data Mapel', $mapel);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'kd_mapel'    => 'required',
            'nama_mapel'  => 'required',
            'nama_guru'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create news
        $mapel = Mapel::create([
            'kd_mapel'    => $request->kd_mapel,
            'nama_mapel'  => $request->nama_mapel,
            'nama_guru'   => $request->nama_guru,
        ]);

        //return response
        return new PostResource(true, 'Data Mapel Berhasil Ditambahkan!', $mapel);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mapel = Mapel::where('kd_mapel',$id)
        ->get();

        return new PostResource(true, 'Data Mapel Ditemukan!', $mapel);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kd_mapel'    => 'required'. $id,
            'nama_mapel'  => 'required',
            'nama_guru'   => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {
            $mapel = Mapel::find($id);
            if (!$mapel) {
                return response()->json(['error' => 'Data Mapel tidak ditemukan'], 404);
            }
    
            $mapel->update([
                'kd_mapel'    => $request->kd_mapel,
                'nama_mapel'  => $request->nama_mapel,
                'nama_guru'   => $request->nama_guru,
            ]);


            return new PostResource(true, 'Data Mapel Berhasil Diubah!', $mapel);
        } catch (\Exception $e) {
            return new PostResource(false, 'Data Mapel Gagal Diubah!', [
                'details' => $e->getMessage(),
                500
            ]);
        }
    }

    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();

        return new PostResource(true, 'Data Mapel Berhasil Dihapus!', null);
    }
}
