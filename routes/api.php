<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostUserController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\JadwalController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth:sanctum')->get('/user', [PostUserController::class, 'user'])->name('user');
// Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'show'])->name('show');
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//     Route::resource('/posts', PostUserController::class);
// });

// Route::group(['middleware' => ['auth:sanctum']], function() {
//     Route::get('/user', [AuthController::class, 'show']);->name('show');
//     Route::post('/logout', [AuthController::class, 'logout']);->name('logout');
// })

Route::apiResource('/posts', PostUserController::class);
Route::apiResource('/news', NewsController::class);
Route::apiResource('/jadwal', JadwalController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);

// // Protected Routes
// Route::group(['middleware' => ['auth:sanctum']], function() {

//     // User
//     Route::get('/user', [AuthController::class, 'user']);
//     Route::put('/user', [AuthController::class, 'update']);
//     Route::post('/logout', [AuthController::class, 'logout']);

//     // Post
//     Route::get('/posts', [PostController::class, 'index']); // all posts
//     Route::post('/posts', [PostController::class, 'store']); // create post
//     Route::get('/posts/{id}', [PostController::class, 'show']); // get single post
//     Route::put('/posts/{id}', [PostController::class, 'update']); // update post
//     Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete post

//     // Comment
//     Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
//     Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
//     Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
//     Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

//     // Like
//     Route::post('/posts/{id}/likes', [LikeController::class, 'likeOrUnlike']); // like or dislike back a post
// });