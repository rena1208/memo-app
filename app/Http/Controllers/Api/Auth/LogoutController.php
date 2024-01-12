<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Hash;
use App\Models\User;


class LogoutController extends Controller
{
    public function logout() {
        Auth::guard('web')->logout();

        return response()->json(['message' => 'ログアウトしました。']);
    }

}
