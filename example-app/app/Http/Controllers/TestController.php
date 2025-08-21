<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Userモデルファイルの場所を示したuse宣言
use App\Models\User;

class TestController extends Controller
{
    //どのファイルを表示するかを指定
    public function test() {
        // usersテーブルに入っているレコードを全て取得し、$users変数に代入
        $users = User::all();
        //ビューファイルを表示する時に$users変数も受け渡すためのコード（compact関数で受け渡し）
        return view('test', compact('users'));
    }
}
