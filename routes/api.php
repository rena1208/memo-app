<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

// use App\Models\User;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//ログイン
Route::post('/login',[LoginController::class,'login']);
//ユーザー新規登録
Route::post('/register', [UserController::class,'register']);
// Route::post('/post',[PostController::class,'postNote']);

//ログインユーザーの機能
Route::group(['middleware' => 'auth:sanctum'], function () {
    //ログインユーザーの情報とメモの取得
    // Route::get('/user/{userid}',[UserController::class,'index']);
    Route::get('/user',[UserController::class,'index']);
    //ログアウト
    Route::post('/logout',[LogoutController::class,'logout']);
    //メモの投稿
    Route::post('/user/post',[PostController::class,'store']);
    //メモの詳細
    Route::get('/user/post/{postid}/detail',[PostController::class,'postDetail']);
    //メモの削除機能
    Route::delete('/user/post/{postid}', [PostController::class, 'deletePost']);
    //メモの編集機能
    Route::post('/user/post/{postid}/edit',[PostController::class,'postEdit']);
});