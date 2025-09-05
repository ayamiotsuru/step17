<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            投稿検索
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- 検索フォーム -->
                <input
                    type="text"
                    id="search"
                    data-ajax-url="{{ route('ajax.search') }}"
                    placeholder="検索"
                    class="border rounded p-2 w-full mb-4"
                />

                <!-- 結果表示 -->
                <ul id="results" class="list-disc pl-5"></ul>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/ajax-search.js') }}"></script>
</x-app-layout>
