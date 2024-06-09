    <h1>商品一覧画面</h1>

    <!-- 新規登録画面へ -->
    <a href="{{ route('show.regist') }}" class="btn btn-primary mb-3">商品新規登録</a>
   
    <!-- キーワード検索フォーム -->
    <form action="{{ route('show.list') }}" method="GET">
    @csrf
        <input type="text" name="keyword" placeholder="検索キーワード">
    
    <!-- プルダウン検索（メーカー名） -->
    <div>
        <select name="company" data-toggle="select">
            <option value="">メーカー名</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}">
                    {{ $company->company_name }}                
                </option>
            @endforeach
        </select>
        <button>検索する</button>
    </div>
    </form>

    <div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>コメント</th>
                <th>メーカー名</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->comment }}</td>
                <td>{{ $product->company_name }}</td>
                <td>
                    <!-- 選択したカラム行の情報を持って、詳細画面へ -->
                    <a href="{{ route('show.detail', ['id' => $product->id]) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                    <!-- 行削除ボタン -->
                    <form method="POST" action="{{ route('delete.product', ['id' => $product->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm mx-1" onclick='return confirm("本当に削除しますか？")'>削除</button>
                    </form>
                </td>
            </tr>            
            @endforeach
        </tbody>
    </table>
    <!-- ページネーション -->
    {{ $products->links() }}
    </div>

