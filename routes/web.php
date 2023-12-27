<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use App\Http\Controllers\LoginController;
// use App\Http\Controllers\PostController;
// use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// //ログイン
// Route::post('/login',[LoginController::class,'login']);
// //ユーザー新規登録
// Route::post('/register', [UserController::class,'register']);

// Route::post('/post',[PostController::class,'store']);
// Route::group(['middleware' => 'auth:sanctum'],function(){
//     Route::get('/user',[UserController::class,'index']);
//     //メモの登録
//     Route::post('/post',[PostController::class,'store']);
// });
