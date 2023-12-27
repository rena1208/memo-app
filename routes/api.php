<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
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


// Route::group(['middleware' => 'auth:sanctum'],function(){
//     Route::get('/user',[UserController::class,'index']);
//     //メモの登録
//     Route::post('/post',[PostController::class,'store']);
// });
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user',[UserController::class,'index']);
    // Route::get('/user', function (Request $request) {
    //     $user = $request->user();
    //     \Log::info($user);
    //     return $user;
    // });
    // Route::post('/posts', function (Request $request) {
    //     $users = User::all();
    //     return response()->json(compact('users'),200);
    //  });
    Route::post('/post',[PostController::class,'store']);
});
// Route::get('/user', [UserController::class,'index']);