<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h1>投稿検索</h1>
                <input type="text" id="search" placeholder="タイトルを入力">
                <ul id="results"></ul>

            </div>
        </div>
    </div>
    <script>
        const searchInput = document.getElementById('search');
        const resultsList = document.getElementById('results');

        // keyupイベント：キーを離したタイミングで発火
        // async functionで関数を非同期処理として定義、awaitが使えるように。
        searchInput.addEventListener('keyup', async function() {
            // 入力欄の文字列を取得して前後の空白を削除
            let query = this.value.trim();
            // もし入力値が空なら結果リストをクリアして処理を終了
            if (!query) {
                resultsList.innerHTML = '';
                return;// 処理終了
            }

            try {
            // tryの中に非同期処理を書く
            // awaitでその非同期処理が終わるまで次の処理を待機
                // fetch(url)：指定したURLにGETリクエストを送信。ルートで定義したURLの後ろに、クエリパラメータとして検索文字列を渡す。encodeURIComponent()で日本語や特殊文字も安全に送信。
                // resにはサーバーが返した結果が入る。結果とは、ステータス（200 OKや　404など）、ヘッダー（Content-Type, Content-Length）、ボディ（サーバーが返したデータ本体（JSON文字列など））
                const res = await fetch(`{{ route('ajax.search') }}?query=${encodeURIComponent(query)}`);

                // res.json()でJSON文字列→JSオブジェクト/配列に変換し扱いやすくしている。※.jsonファイルを作ってるわけではないので勘違い注意
                // 配列としてすでに検索結果が入っている。
                const data = await res.json();

                // 検索結果を表示るすエリア（HTML側）をクリアにしておく。
                resultsList.innerHTML = '';

                // 検索結果が0であれば処理終了
                // 上で検索結果をすでに取得しているので、配列の長さを見れば結果が0件かどうか判定できる。
                if (data.length === 0) {
                    resultsList.innerHTML = '<li>該当なし</li>';
                    return;// 処理を終了
                }

                // サーバーから取得した検索結果を画面に表示する処理
                // forEachは配列の各要素に対して処理を繰り返すメソッド
                // postは配列の要素1つ分（1塊）を指す　例1回目：post = {id:1, title:"テスト1"} 2回目：post = {id:2, title:"テスト2"}
                data.forEach(post => {
                    const listItem = document.createElement('li');// li要素を作成
                    listItem.textContent = post.title; // 配列のタイトルをセット
                    resultsList.appendChild(listItem); // resultsList（ul）の中にlistItem（li）を追加
                });

            } catch (error) {
                // catch内に非同期処理が失敗した時の処理
                // console.logは普通の確認用。console.errorはエラー用
                console.error(error);
            }
        });
    </script>
</x-app-layout>
