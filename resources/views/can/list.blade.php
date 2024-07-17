@extends('layouts.app')

@section('content')
   <h1>商品一覧画面</h1>

    <!-- 新規登録画面へ -->
    <a href="{{ route('show.regist') }}" class="btn btn-primary mb-3">商品新規登録</a>
   
    <!-- キーワード検索フォーム -->
    <form action="{{ route('show.list') }}" method="GET">
    @csrf
        <!-- 商品名検索用の入力欄 -->
        <label class="col-sm-12 col-md-3">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名検索">
        </label>

        <!-- 最小価格の入力欄 -->
        <label class="col-sm-12 col-md-2">
            <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
        </label>

        <!-- 最大価格の入力欄 -->
        <label class="col-sm-12 col-md-2">
            <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
        </label>

        <!-- 最小在庫数の入力欄 -->
        <label class="col-sm-12 col-md-2">
            <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
        </label>

        <!-- 最大在庫数の入力欄 -->
        <label class="col-sm-12 col-md-2">
            <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
        </label>


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

        <!-- メッセージ表示 -->
        @if(session('message'))
            <x-message :message="session('message')" />
        @endif

    <div>
        <table class="table">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>
                        価格
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'asc']) }}">↑</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'desc']) }}">↓</a>
                    </th>
                    <th>
                        在庫数
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'asc']) }}">↑</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'desc']) }}">↓</a>
                    </th>
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
                    <td>{{ $product->companies->company_name }}</td>
                    <td>
                        <!-- 選択したカラム行の情報を持って、詳細画面へ -->
                        <a href="{{ route('show.detail', ['id' => $product->id]) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                        <!-- 行削除ボタン -->
                        <button data-user_id="{{ $product->id }}" type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    <!-- ページネーション -->
    {{ $products->appends(request()->query())->links() }}
    </div>


    <script type="text/javascript">
        // トークンを送信する記述
        // Laravelでは通信をする際にトークンを送らなければ仕様でエラーが発生する
        // サーバーに繰り返し実行する前に、パラメータのデフォルトを設定
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $(function(){
            $('.btn-danger').on('click', function(){
                var deleteConfirm = confirm('本当に削除しますか？');

                if(deleteConfirm == true){
                    var clickEle = $(this);
                    var userID = clickEle.attr('data-user_id');

                    // Ajaxリクエストが行われるたびに、URLと他が自動的に使用される
                    $.ajax({
                            type: 'POST',
                            url: 'destroy/'+userID,
                            data: {'id':userID,
                                   '_method': 'DELETE'}
                            })
                            .done(function() {
                                // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
                                clickEle.parents('tr').remove();
                            })

                            } else {
                            (function(e) {
                            e.preventDefault() // 元々の処理を無効化
                    });
                };
            });
        });
    </script>

    @endsection