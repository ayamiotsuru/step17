<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            フォーム
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        @if (session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif
        <div class="bg-white w-full rounded-2xl">
            <h1 class="text-lg font-semibold">
                {{ $post->title }}
            </h1>
            <div class="text-right flex">
                <a href="{{ route('post.edit', $post) }}" class="flex-1">
                    <x-primary-button>
                        編集
                    </x-primary-button>
                </a>
                <form method="post" action="{{ route('post.destroy', $post) }}" class="flex-2">
                    @csrf
                    @method('delete')
                    <x-primary-button class="bg-red-700 ml-2">
                        削除
                    </x-primary-button>
                </form>
            </div>
            <hr class="w-full">
            <p class="mt-4 whitespace-pre-line">
                {{ $post->body }}
            </p>
            <div class="text-sm font-semibold flex flex-row-reverse">
                <p>{{ $post->create_at }}</p>
            </div>
        </div>
    </div>
    {{-- コメント一覧 --}}
    @forelse ($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <p class="card-text">{{ $comment->content}}</p>
                <p class="text-muted">投稿者:{{ $comment->user->name}}</p>
            </div>
        </div>
    @empty
        <p class="text-gray-500">まだコメントはありません。</p>
    @endforelse
    {{-- コメントフォーム --}}
    <h3>コメントを投稿する</h3>
    <form method="post" action="{{ route('comments.store', $post->id) }}" class="flex-2">
        @csrf
        <div class="mb-3">
            <label for="content">コメント内容</label>
            <textarea name="content" id="content" cols="30" rows="10" required></textarea>
        </div>
        <button type="submit">コメント投稿</button>
    </form>
</x-app-layout>
