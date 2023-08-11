<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            'nis' => 'string|max:45',
            'nik' => '',
            'username' => 'string|max:255|unique:users',
            'password' => 'string|max:100|min:6',
            'nama' => 'string|max:255',
            'jenis_kelamin' => 'string|max:45',
            'tanggal_lahir'=> '',
            'alamat' => '',
            'kelas' => 'string|max:45',
            'jurusan' => 'string|max:45',
            'no_tlp' => '',
            'tahun_masuk' => '',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = new user;
        $user->nis = $request->nis;
        $user->nik = $request->nik;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->nama = $request->nama;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->alamat = $request->alamat;
        $user->kelas = $request->kelas;
        $user->jurusan = $request->jurusan;
        $user->no_tlp = $request->no_tlp;
        $user->tahun_masuk = $request->tahun_masuk;
        $user->save();

        $token = $user->createToken('regis_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }


    public function login(Request $request)
    {
        $messages = [
            'username.required' => 'Username is required!',
            'password.required' => 'Password is required!'
        ];

        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required|string',
            'remember_token' => 'boolean',
        ], $messages);

        $user = User::where('username', $request->username)->first();

        $credentials = request(['username', 'password']);
        if (!Auth::once($credentials)) {
            return response([
                'success'   => false,
                'message' => ['Username atau Password Salah!']
            ], 404);
        }

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
}
