<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function create()
    {
        return view('post.create');
    }

    public function update(Request $request, Post $post)
    {
        // Gate::authorize('test');
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        // $post = Post::create($validated);
        $request->session()->flash('message', '更新しました');
        return back();
    }

    public function destroy(Request $request, Post $post) {
        $post->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('post.index');
    }

    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->get();
        // $posts = Post::whereDate('created_at', '<=', '2025-08-27')->get();
        return view('post.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('post.show', compact('post'));
    }
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }
}
