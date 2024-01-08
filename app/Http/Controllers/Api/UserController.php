<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    //ログイン後ユーザーの情報を返す
    public function index(Request $request, $userid)
    {
        // $users = User::all();
        $user = $request->user();
        $userid = 1;
        //ログの出力
        // \Log::info($request->url());
        \Log::info($userid);
        \Log::info(auth()->user());

        return $user;
        // return response()->json(compact('user'),200);
    }

    //ユーザーの新規登録
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'  => 'required|email|unique:users,email',
            'password' => 'required|max:30|min:4'
        ],
        // [
        //     'name.required' => 'お名前は必須です',
        //     'email.required' => 'メールアドレスは必須です',
        //     'email.email' => '正しいメールアドレスの形式で入力してください',
        //     'email.unique' => 'すでに登録されているメールアドレスです',
        //     'password.required' => 'パスワードは必須です',
        //     'password.max' => 'パスワードは:max文字以下で入力してください',
        //     'password.min' => 'パスワードは:min文字以上で入力してください',
        // ]
        );
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $postUser = new User;
        $postUser->name = $request->name;
        $postUser->email = $request->email;
        $request->validate(['email' =>['required','confirmed']]);
        $postUser->password = Hash::make($request->password);
        $request->validate(['password' =>['required','confirmed']]);
        $postUser->save();


}
       
    }
