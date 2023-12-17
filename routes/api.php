<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\PostUserController;
use App\Http\Controllers\Api\UserController;


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


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('/user',[UserController::class,'index']);
    Route::post('/post',[PostController::class,'store']);
});
// Route::get('/user', [UserController::class,'index']);
