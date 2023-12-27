<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    //ログイン後ユーザーの情報を返す
    public function index(Request $request)
    {
        // $users = User::all();
        $user = $request->user();
        //ログの出力
        // \Log::info($request->url());
        // \Log::info($user);
        \Log::info(auth()->user());
        // \Log::info($request->session()->all());
        // \Log::info($request->cookies->all());
        // \Log::info($request->cookie('XSRF-TOKEN'));
        // \Log::info($request->headers->all());
        // \Log::info(config('session'));
        // \Log::info(config('cors'));
        // \Log::info(file_get_contents(base_path('.env')));
        return $user;
        // return response()->json(compact('user'),200);
    }

    //ユーザーの新規登録
    public function register(Request $request){
        $postUser = new User;
        $postUser->name = $request->name;
        $postUser->email = $request->email;
        $request->validate(['email' =>['required','confirmed']]);
        $postUser->password = Hash::make($request->password);
        $request->validate(['password' =>['required','confirmed']]);
        $postUser->save();

        // $postUser = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'email' => $request->validate(['email' =>['required','confirmed']]),
        //     'password' => Hash::make($request->password),
        //     'password'=> $request->validate(['password' =>['required','confirmed']]),
        // ]);

        // Auth::login($postUser);

        // return response()->json(['message' => 'User registered and logged in successfully.']);
    //     try {
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $request->session()->regenerate();
    
    //         return new JsonResponse([
    //             'message' => 'Authenticated.',
    //         ]);
    //     }
    // }catch (\Exception $e) {
    //     // 例外をログに記録する
    //     \Log::error('Login error: ' . $e->getMessage());
    //     // throw ValidationException::withMessages([
    //     //         'email' => ['メールアドレス、もしくはパスワードが違います'],
    //     //     ]);
    // }

}
       
    }
