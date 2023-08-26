<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bayar;

class BayarController extends Controller
{
    public function index(){

        $bayar = Bayar::orderBy('tahun','asc')->orderBy('nis', 'asc')
        ->with(['user'])
        ->get();
        
        //return collection of news as a resource
        return new PostResource(true, 'List Bayar', $bayar);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nis'        => 'required',
            'nama_bayar'  => 'required',
            'bulan'  => 'required',
            'semester'  => 'required',
            'nominal'  => 'required',
            'jumlah_bayar'  => '',
            'tgl_bayar'  => '',
            'ket'  => '',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create news
        $bayar = Bayar::create([
            'nis'        => $request->nis,
            'nama_bayar'   => $request->nama_bayar,
            'bulan'      => $request->bulan,
            'semester'   => $request->semester,
            'nominal'   => $request->nominal,
            'jumlah_bayar'   => $request->jumlah_bayar,
            'tgl_bayar'      => $request->tgl_bayar,
            'ket'   => $request->ket,
        ]);

        //return response
        return new PostResource(true, 'Data Pembayaran Siswa Berhasil Ditambahkan!', $bayar);
    }

    public function show($id)
    {
        $bayar = Bayar::where('nis',$id)
        ->with(['user'])
        ->get();

        return new PostResource(true, 'Data Pembayaran Siswa Ditemukan!', $bayar);
        
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nis'        => 'required',
            'nama_bayar'  => 'required',
            'bulan'  => 'required',
            'semester'  => 'required',
            'nominal'  => 'required',
            'jumlah_bayar'  => '',
            'tgl_bayar'  => '',
            'ket'  => '',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        try {
            $bayar = Bayar::find($id);
            if (!$bayar) {
                return response()->json(['error' => 'Data Pembayaran Siswa tidak ditemukan'], 404);
            }
    
            $bayar->update([
                'nis'        => $request->nis,
                'nama_bayar'   => $request->nama_bayar,
                'bulan'      => $request->bulan,
                'semester'   => $request->semester,
                'nominal'   => $request->nominal,
                'jumlah_bayar'   => $request->jumlah_bayar,
                'tgl_bayar'      => $request->tgl_bayar,
                'ket'   => $request->ket,
            ]);


            return new PostResource(true, 'Data Pembayaran Siswa Berhasil Diubah!', $bayar);
        } catch (\Exception $e) {
            return new PostResource(false, 'Data Pembayaran Siswa Gagal Diubah!', [
                'details' => $e->getMessage(),
                500
            ]);
        }
    }

    public function destroy($id)
    {
        $bayar = Bayar::findOrFail($id);
        $bayar->delete();

        return new PostResource(true, 'Data Pembayaran Siswa Berhasil Dihapus!', null);
    }
}
