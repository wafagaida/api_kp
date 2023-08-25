<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PostUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(User::orderBy('nis', 'ASC')->get());
        $user = User::orderBy('kd_kelas','asc')->orderBy('nis','asc')
        ->with(['kelas'])
        ->get();
        //get posts
        // $user = User::latest()->paginate(10);

        // //return collection of posts as a resource
        return new PostResource(true, 'List Data Siswa', $user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string|max:45',
            'nik' => 'required|',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:100|min:6',
            'nama' => 'string|max:255',
            'jenis_kelamin' => 'string|max:45',
            'tanggal_lahir' => '',
            'alamat' => '',
            'tingkat' => '',
            'jurusan' => 'string|max:45',
            'kd_kelas' => 'string|max:45',
            'no_tlp' => '',
            'tahun_masuk' => '',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'nis'      => $request->nis,
            'nik'     => $request->nik,
            'username'     => $request->username,
            'password'  => Hash::make($request->password),
            'nama'     => $request->nama,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'alamat'     => $request->alamat,
            'tingkat'     => $request->tingkat,
            'jurusan'     => $request->jurusan,
            'kd_kelas'     => $request->kd_kelas,
            'no_tlp'     => $request->no_tlp,
            'tahun_masuk'     => $request->tahun_masuk,
        ]);

        return new PostResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {   
        $user = User::where('nis',$id)
        ->with(['kelas'])
        ->get();
        $kd_kelas = $user->groupBy('nis');
        return new PostResource(true, 'Data Siswa Ditemukan!', $user, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nis)
{
    $validator = Validator::make($request->all(), [
        'nis' => 'required|string|max:45',
        'nik' => 'required|',
        'username' => '|string|max:255|unique:users',
        'password' => '|string|max:100|min:6',
        'nama' => 'string|max:255',
        'jenis_kelamin' => 'string|max:45',
        'tanggal_lahir' => '',
        'alamat' => '',
        'tingkat' => '',
        'jurusan' => 'string|max:45',
        'kd_kelas' => 'string|max:45',
        'no_tlp' => '',
        'tahun_masuk' => '',
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    try {
        if($validator) :
            $user = User::find($nis)->update([
                'nis'      => $request->nis,
                'nik'     => $request->nik,
                'username'     => $request->username,
                'password'  => Hash::make($request->password),
                'nama'     => $request->nama,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'alamat'     => $request->alamat,
                'tingkat'     => $request->tingkat,
                'jurusan'     => $request->jurusan,
                'kd_kelas'     => $request->kd_kelas,
                'no_tlp'     => $request->no_tlp,
                'tahun_masuk'     => $request->tahun_masuk,
            ]);


            return new PostResource(true, 'Data Siswa Berhasil Diubah!', $user);
        endif;
    } catch (\Exception $e) {
        return new PostResource(false, 'Data Siswa Gagal Diubah!', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return new PostResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
