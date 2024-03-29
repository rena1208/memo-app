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
    //メモの新規投稿
    public function store(Request $request){
        //バリデーション
            $validator = Validator::make($request->all(), [
                'title'  => 'max:30',
                'text' => 'required|max:300'
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

        // session()->flash('flash.success', '登録に成功しました');
        // $headerValue = $request->header('header_name');
        // \Log::info(response()->json(compact('post')));
        // \Log::info($post);
        // \Log::info(session('flash.success'));
        return response()->json(compact('post'),200);
        
        // \Log::info(auth()->user());
        // \Log::info(Auth::id());

        
    }

    //メモの詳細データ表示
    public function postDetail($postid) {
        $userid = Auth::id();
        $post = Post::where('user_id', $userid)->findOrFail($postid);

        \Log::info($userid);
        \Log::info($post);
        \Log::info($postid);
        return response()->json($post);

    }
    

    //メモの削除機能
    public function deletePost($postid) {
        $user = Auth::user();
        $userid = Auth::id();
        $post = Post::where('user_id', $userid)->findOrFail($postid);
        $post->delete();
        // $post =Post::where('user_id', $user->id)->where('id', $user->id);
        // \Log::info(response()->json(compact('post')));
        return response()->json(compact('post'),200);
        // \Log::info($user);
        // \Log::info($userid);
        // \Log::info($post);
        // \Log::info($postid);
        
    }

    //メモの編集機能
    public function postEdit(Request $request, $postid) {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'title'  => 'max:30',
            'text' => 'required|max:300'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        //データの更新
        // $user = Auth::user();
        $userid = Auth::id();
        $post = Post::where('user_id', $userid)->findOrFail($postid);
        $post->title = $request->title;
        $post->text = $request->input('text');
        $post->save();
        // \Log::info($user);
        // \Log::info($userid);
        \Log::info($post);
        \Log::info($postid);
        \Log::info($post->title);
        \Log::info($post->text);
        return response()->json(compact('post'),200);
    }
}
