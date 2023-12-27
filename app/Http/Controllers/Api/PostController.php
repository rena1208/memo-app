<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    //
    public function store(Request $request){
        $user = User::all();
        $user = $request->user();
        \Log::info($request->user());
        \Log::info(auth()->user());
        \Log::info(Auth::id());
        // \Log::info($request->title);
        // \Log::info($request->input('text'));
        // \Log::info($request->cookies->all());
        // // \Log::info($request->cookie('XSRF-TOKEN'));
        // \Log::info($request->headers->all());
        // // \Log::info(config('session'));
        // // \Log::info(config('cors'));
        // \Log::info(file_get_contents(base_path('.env')));
        
        $allHeaders = $request->headers->all();
        $allCookies = $request->cookies->all();
        $post = new Post;
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->text = $request->input('text');
        $post->save();
        \Log::info($request->user());
        \Log::info(auth()->user());
        \Log::info(Auth::id());
        \Log::info($request->session()->all());
        \Log::info($request->cookies->all());
        \Log::info($request->headers->all());
        $headerValue = $request->header('header_name');
    }
}
