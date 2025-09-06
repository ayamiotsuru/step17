<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    //リアルタイム検索のためのコントローラー
    public function ajaxSearch(Request $request) {
        // ユーザーがフォームやAJAXで送ったqueryの値を$queryに入れて後の検索処理などに使えるように設定
        // query は単なる名前（キー）開発者が「検索ワード用の値だから query にする」と決めたもの。JavaScriptのfetchでも同じ名前を使う必要がある。
        $query = $request->input('query');

        $request = [];// 空配列で初期化しておく。

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

    //リアルタイム検索ページ（search.blade.php）表示のため
    // public function showSearchForm()
    // {
    //     return view('post.search'); // resources/views/posts/search.blade.php
    // }
}


