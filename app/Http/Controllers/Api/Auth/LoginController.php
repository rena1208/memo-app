<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //関数を追記
    // public function login(Request $request)
    // {
    //     $email = $request->email;
    //     $password = $request->password;
    //     \Log::info($email);
    //     \Log::info($password);

    //     $user = User::where('email', $email)->first();

    //       // Hash::check(今入力されたパスワード、DBに保存された暗号化済みのパスワード)
    //     if (! $user || ! Hash::check($password, $user->password)) {
    //        //ユーザーがいない｜または｜DBのパスワードと合致していれば
    //         throw ValidationException::withMessages([
    //             'email' => ['メールアドレス、もしくはパスワードが違います'],
    //         ]);
    //     }

    //     $token = $user->createToken('token')->plainTextToken;
    //     //tokenという名前で返す
    //     return response()->json(compact('token'),200);
    // }

    public function login(Request $request)
    {
    // try {
    //     $credentials = $request->only(['email', 'password']);
        
    //         if (Auth::attempt($credentials)) {
    //             $request->session()->regenerate();


    //         return new JsonResponse([
    //             'message' => '認証成功！',
    //         ]);
    //         }else {
    //         // ユーザーがいない｜または｜DBのパスワードと合致していなければ
    //         throw ValidationException::withMessages([
    //             'email' => ['メールアドレス、もしくはパスワードが違います'],
    //         ]);
    //     }
    // }catch (\Exception $e) {
    //     // 例外をログへ
    //     \Log::error('Login error: ' . $e->getMessage());
    //     throw ValidationException::withMessages([
    //             'email' => ['メールアドレス、もしくはパスワードが違います'],
    //         ]);
    // }
    // }
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);
    // 認証が成功した場合の処理
    if (Auth::attempt($credentials)) {
        // セッションIDの再生成
        $request->session()->regenerate();
        return response()->json(['message' => 'ログイン成功']);
    }
}

}
