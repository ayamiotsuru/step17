<div class="search-component">
    <input
        type="text"
        class="search-input border rounded p-2 w-full mb-4"
        placeholder="検索"
        data-ajax-url="{{ route('ajax.search') }}"
    />
    <ul class="search-results list-disc pl-5"></ul>
</div>
