<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\PostUserController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\NilaiController;
use App\Http\Controllers\Api\BayarController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\Api\ImageController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/adLogin', [AdminController::class, 'adLogin'])->name('adLogin');
Route::post('/adRegister', [AdminController::class, 'adRegister'])->name('adRegister');
Route::middleware('auth:sanctum')->post('/adLogout', [AdminController::class, 'adLogout'])->name('adLogout');

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth:sanctum')->get('/user', [PostUserController::class, 'user'])->name('user');

Route::apiResource('/posts', PostUserController::class);
Route::apiResource('/news', NewsController::class);
Route::apiResource('/jadwal', JadwalController::class);
Route::apiResource('/nilai', NilaiController::class);
Route::apiResource('/bayar', BayarController::class);
Route::apiResource('/kelas', KelasController::class);
Route::apiResource('/mapel', MapelController::class);

Route::get('/image/{imageName}', [ImageController::class, 'getImage']);

// Route::get('/image/{imageName}', 'ImageController@getImage');

// Route::get('/posts', [PostUserController::class, 'index']);
// Route::get('/posts/{posts}', [PostUserController::class, 'show']);
// Route::post('/posts', [PostUserController::class, 'store']);
// Route::put('/posts/{posts}', [PostUserController::class, 'update']);
// Route::delete('/posts/{posts}', [PostUserController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});