<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::all();
        $user = $request->user();
        \Log::info($request->url());
        \Log::info($user);
        \Log::info(auth()->user());
        return response()->json(compact('user'),200);
    }

    public function guest()
    {

    }
}
