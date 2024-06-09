<div class="links">
    <h1>詳細画面</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>メーカー名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>コメント</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product->id }}</td>
                <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->company_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->comment }}</td>
                <td>
                    <!-- 選択したカラム行の情報を持って、編集画面へ -->
                    <a href="{{ route('show.edit', ['id' => $product->id]) }}">商品編集</a>
                </td>
                <td>
                    <a href="{{ route('show.list') }}">戻る</a>
                </td>
            </tr>            
        </tbody>
    </table>
</div>