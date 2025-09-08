<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::all();
        $posts = Post::paginate(10);
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
            'tags' => 'nullable|string|max:50',// タグなしでもOK
        ]);

        // null合体演算子、$validated['tags']が存在していれば、$tagsInput = tags
        // $validated['tags']がなければ$tagsInputに空文字''を入れる（$tagsInputがnullや未定義だとエラーになる可能性がある）
        $tagsInput = $validated['tags'] ?? '';
        // PHP関数は内側から外側へ順に処理される
        // explode(',', $tagsInput)でカンマで文字列を分割して配列に
        // array_map('trim', ...)でarray_mapは配列の各要素に関数を適用する = 各要素の前後の空白を削除
        // array_filterは配列から「falseに評価される値」を取り除く = 空文字やnullを削除
        $tags = array_filter(array_map('trim', explode(',', $tagsInput)));
        // 重複を削除
        $tags = array_unique($tags);

        // 空の配列を用意
        $tagIds = [];
        //foreach ( $配列 as $要素 )のため、$tagNameはループ1回ごとの1塊を指す
        foreach ($tags as $tagName) {
            // Tagテーブルでタグ名を探す、あれば取得、なければ作成
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            // IDがちゃんと取れていれば追加
            if ($tag && $tag->id) {
                $tagIds[] = $tag->id;
            }
        }

        $validated['user_id'] = auth()->id(); // ログインしているユーザーのIDを、保存するデータに追加している

        $post = Post::create($validated);// データベースに保存

        // タグを中間テーブルに登録
        $post->tags()->sync($tagIds);

        $request->session()->flash('message', '保存しました');
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('comments.user');
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        // $post = Post::create($validated);
        $request->session()->flash('message', '更新しました');
        return redirect()->route('post.show', compact('post'));
        // return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $post->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('post.index');
    }

    // タグ検索用メソッド
    public function searchByTag(Request $request)
    {
        $tagName = $request->input('tag'); // 例: URL ?tag=Laravel

        // タグ名で検索
        $posts = Post::whereHas('tags', function($query) use ($tagName) {
            $query->where('name', $tagName);
        })->get();

        return view('post.index', compact('posts')); // ビューに渡す
    }

}
