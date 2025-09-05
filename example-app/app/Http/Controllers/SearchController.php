<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    //リアルタイム検索のためのコントローラー
    public function ajaxSearch(Request $request) {
        $query = $request->input('query');

        $request = [];// 返却用の変数を用意しておく。（空配列で初期化）

        // $queryが空でなければ検索を実行(条件式の意味は0は検索対象で、nullと空文字''は除外)
        if (!empty($query)) {
            // Postテーブルを検索
            // 'LIKE'はSQLの演算子で部分一致検索
            // %{$query}%の%は「含まれているか」をチェック、{}は必須ではないが変数の境界を明示するための書き方で安全＆可読性がよい
            $results = Post::where('title', 'LIKE', "%{$query}%")
            ->limit(10) //最大10件
            ->get(['id', 'title']);// 使用するカラムだけを取得
        }
        return response()->json($results);// コントローラで取得したデータをJSON形式に変換して返す(非同期通信のため)
    }

    public function showSearchForm()
    {
        return view('post.search'); // resources/views/posts/search.blade.php
    }
}


