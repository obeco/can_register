

<div class="form-group row">
    <form method="post" action="{{ route('update.product', ['id' => $product->id ]) }}" enctype="multipart/form-data">        
    @csrf
        <div>
            <label for="ID">ID</label>
            <p>"{{ $product->id }}"</p>
        </div>

        <div>
            <label for="product_name">商品名</label>
            <input type="text" name="product_name" id="product_name" value="{{ $product->product_name }}">
        </div>

        <div>
            <label for="company_name">メーカー名</label>
            <select name="company" data-toggle="select">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">
                        <!-- もともとdetailで選択されていたメーカー名が選択された状態にしたい 未完了 -->
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="price">価格</label>
            <input type="text" name="price" id="price" value="{{ $product->price }}">
        </div>

        <div>
            <label for="stock">在庫数</label>
            <input type="text" name="stock" id="stock" value="{{ $product->stock }}">
        </div>

        <div>
            <label for="comment">コメント</label>
            <input type="text" name="comment" id="comment" value="{{ $product->comment }}">
        </div>

        <div>
            <!-- 画像がある場合 -->
            @if ($product->image !=='')
            <img src="{{ asset($product->img_path) }}" alt="商品画像" width="100">
            <!-- 画像がない場合 -->
            @else
            <p>画像なし</p>
            @endif
            <input id="image" type="file" name="image" class="form-control">
        </div>

        <button type="submit">更新する</button>
    </form>
    <a href="{{ route('show.list') }}">戻る</a>
</div>