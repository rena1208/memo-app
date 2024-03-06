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
    public function login(Request $request)
    {
    try {
        $credentials = $request->only(['email', 'password']);
        
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();


            return new JsonResponse([
                'message' => '認証成功！',
            ]);
            \Log::info($user);
            \Log::info($email);
            }else {
            // ユーザーがいない｜または｜DBのパスワードと合致していなければ
            throw ValidationException::withMessages([
                'email' => ['メールアドレス、もしくはパスワードが違います'],
            ]);
        }
    }catch (\Exception $e) {
        // 例外をログへ
        \Log::error('Login error: ' . $e->getMessage());
        throw ValidationException::withMessages([
                'email' => ['メールアドレス、もしくはパスワードが違います'],
            ]);
    }
    }
    
}

