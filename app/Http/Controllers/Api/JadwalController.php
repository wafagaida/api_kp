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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get news
        // $news = News::latest()->paginate(5);
        // $user = User::OrderBy('nis', 'ASC')->get();
        // $jadwal = Jadwal_Mapel::get();
        // $jadwal = Jadwal_Mapel::with(['mapel', 'jurusan'])->get();
        $jadwal = Jadwal_Mapel::orderBy('hari','desc')->orderBy('jam', 'asc')
        ->with(['mapel', 'kelas'])
        ->get();
        

        //return collection of news as a resource
        return new PostResource(true, 'List Mapel', $jadwal);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            return response()->json($validator->errors(), 422);
        }

        //create news
        $jadwal = Jadwal_Mapel::updateOrCreate([
            'kd_mapel' => $request->kd_mapel,
            'hari'     => $request->hari,
            'jam'      => $request->jam,
            'kd_kelas'  => $request->kd_kelas,
            'tingkat'  => $request->tingkat,
        ]);

        //return response
        return new PostResource(true, 'Data Mapel Berhasil Ditambahkan!', $jadwal);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwal = Jadwal_Mapel::where('kd_kelas',$id)
        ->with(['mapel', 'kelas'])
        ->get();
        $kd_kelas = $jadwal->groupBy('kd_kelas');
        // $jadwal = Jadwal_Mapel::with(['mapel', 'jurusan'])->get();
        return new PostResource(true, 'Data Mapel Ditemukan!', $jadwal);
        
    }
    

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, News $news)
    // {
    //    //define validation rules
    //    $validator = Validator::make($request->all(), [
    //     'title'     => 'required',
    //     'content'   => 'required',
    // ]);

    // //check if validation fails
    // if ($validator->fails()) {
    //     return response()->json($validator->errors(), 422);
    // }

    // //check if image is not empty
    // if ($request->hasFile('image')) {

    //     //upload image
    //     $image = $request->file('image');
    //     $image->storeAs('public/news', $image->hashName());

    //     //delete old image
    //     Storage::delete('public/news/'.$news->image);

    //     //update news with new image
    //     $news->update([
    //         'image'     => $image->hashName(),
    //         'title'     => $request->title,
    //         'content'   => $request->content,
    //     ]);

    // } else {

    //     //update news without image
    //     $news->update([
    //         'title'     => $request->title,
    //         'content'   => $request->content,
    //     ]);
    // }

    //return response
    // return new PostResource(true, 'Data Pengumuman Berhasil Diubah!', $news);
// }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal_Mapel $jadwal)
    {
        //delete image
        // Storage::delete('public/news/'.$news->image);

        //delete news
        $jadwal->delete();

        //return response
        return new PostResource(true, 'Data Mapel Berhasil Dihapus!', null);
    }
}
