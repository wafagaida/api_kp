<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string|max:45',
            'nik' => 'required|',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:100|min:6',
            'nama' => 'string|max:255',
            'jenis_kelamin' => 'string|max:45',
            'tanggal_lahir' => 'date',
            'alamat' => 'string',
            'tingkat' => 'string',
            'jurusan' => 'string|max:45',
            'kd_kelas' => 'string|max:45',
            'no_tlp' => 'string',
            'tahun_masuk' => 'numeric',
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
        $token = $user->createToken('regis_token')->plainTextToken;

        if ($user) {
            return response()->json([
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('username', $request->username)->first();

        $credentials = request(['username', 'password']);
        if (!Auth::once($credentials)) {
            return response([
                'success'   => false,
                'message' => ['Username atau Password Salah!']
            ], 404);
        }
        $user->save();

        $token = $user->createToken('login-token')->plainTextToken;

        $response = [
            'success'   => true,
            'user'      => $user,
            'token'     => $token,
            'message'   => 'Berhasil Login'
        ];
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $response = [
            'success'   => true,
            'message'   => 'Berhasil Logout'
        ];
        return response($response, 200);
    }

    public function update_password(Request $request, $nis)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::findorfail($nis);
        $user_data = [
            'password' => Hash::make($request->password)
        ];
        $user->update($user_data);

        return new PostResource(true, 'Data Siswa Berhasil Diubah!', $user);
    }

    // public function user()
    // {
    //     $user = User::orderBy('nis','asc')
    //     ->with(['kelas'])
    //     ->get();

    //     return new PostResource(true, 'List Data Siswa', $user);
    // }



    // public function user()
    // {
    //     return response([
    //         'user' => auth()->user()
    //     ], 200);
    // }
}
