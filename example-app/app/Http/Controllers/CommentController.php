<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//ログイン者の情報を使用

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    //storeメソッドは新しいリソースを作成する（DBに保存する）ためのメソッド
    public function store(Request $request, Post $post)
    //Request $requestはフォームから送信されたデータを受け取るオブジェクト
    //Post $postはURLの{post}が数字のIDなら、それを元にLaravelが自動でDBから投稿を探して$postに入れてくれる
    {
        //フォームから送られたcontentが必須かつ最大400文字をチェック
        //すぐ使用するので戻り値を変数に格納していない。
        $request->validate([
            'content' => 'required|max:400',
        ]);

        //フォームから送信されたコメントをデータベースに保存する処理
        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,//フォームから送信されたコメント内容
        ]);

        return redirect()->route('post.show', $post->id);//$post->idはURLの{post}に埋め込まれ、該当の投稿ページに戻る。
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
