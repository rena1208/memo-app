<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    //
    public function store(Request $request){
        //バリデーション
            $validator = Validator::make($request->all(), [
                'title'  => 'max:30',
                'text' => 'required|max:150'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        
        // $allHeaders = $request->headers->all();
        // $allCookies = $request->cookies->all();
        $post = new Post;
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->text = $request->input('text');
        $post->save();
        \Log::info($request->user());
        \Log::info(auth()->user());
        \Log::info(Auth::id());

        // if ($result) {
        //     session()->flash('flash.success', '登録に成功しました');
        // } else {
        //     session()->flash('flash.error', '登録に失敗しました');
        // }
        // $headerValue = $request->header('header_name');
    }
}
