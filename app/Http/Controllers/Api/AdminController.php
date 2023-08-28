<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function adRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|max:45|min:6',
            'nama' => 'required|string|max:45',
            'level' => 'required|string|max:45',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin = Admin::create([
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'nama'      => $request->nama,
            'level'     => $request->level,
            
        ]);
        $token = $admin->createToken('regis_token_admin')->plainTextToken;

        if ($admin) {
            return response()->json([
                'data' => $admin,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        }
    }


    public function adLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response([
                'success'   => false,
                'message' => ['Email atau Password Salah!']
            ], 404);
        }
        // $admin->save();

        $token = $admin->createToken('login-token-admin')->plainTextToken;

        $response = [
            'success'   => true,
            'admin'      => $admin,
            'token'     => $token,
            'message'   => 'Berhasil Login'
        ];
        return response($response, 201);
    }

    public function adLogout(Request $request)
    {
        $admin = $request->admin();
        $admin->currentAccessToken()->delete();
        $response = [
            'success'   => true,
            'message'   => 'Berhasil Logout'
        ];
        return response($response, 200);
    }

    public function update_password(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed'
        ]);
        $admin = Admin::findorfail($nis);
        $admin_data = [
            'password' => Hash::make($request->password)
        ];
        $admin->update($admin_data);

        return new PostResource(true, 'Data Siswa Berhasil Diubah!', $admin);
    }
}
