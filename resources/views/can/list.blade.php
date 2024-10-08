@extends('layouts.app')

@section('content')

   <h1>商品一覧画面</h1>
    <!-- 新規登録画面へ -->
    <a href="{{ route('show.regist') }}" class="btn btn-primary mb-3">商品新規登録</a>
   
    <!-- キーワード検索フォーム -->
    <form action="{{ route('show.list') }}" method="GET" class="mb-3" id="keyword">
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

            <button class="search-button" type="button">検索する</button>
        </div>
    </form>

    <!-- メッセージ表示 -->
    @if(session('message'))
        <x-message :message="session('message')" />
    @endif

    <!-- テーブル -->
        <table id="fav-table" class="table pager-table">
            <thead class="table-primary">
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
            <tbody class="dataList">
                @foreach($products as $product)
                <tr class="">
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
        <div id="pager" class="pager">
            <button type="button" class="first"><<</button>
            <button type="button" class="prev"><</button>
            <span class="pagedisplay"></span>
            <button type="button" class="next">></button>
            <button type="button" class="last">>></button>
            <select class="pagesize" title="Select page size">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
            </select>
            
            <select class="gotoPage" title="Select page number"></select>
        </div>


    <script type="text/javascript">
        // トークンを送信する記述（Laravelでは通信をする際にトークンを送らなければエラー発生する仕様）
        // サーバーに繰り返し実行する前に、パラメータのデフォルトを設定
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // ソート機能（定義）
        function sortTable(){
            $(document).ready(function() {
                $('#fav-table').tablesorter({})
                .tablesorterPager({
                    container: $(".pager"),
                    // 表示したい行数
                    size: 5
                });
            });
        }
        // ソート実行（ページ表示時）
        sortTable();

        // 検索機能
        $(function(){
            $('.search-button').on('click', function(e){
                e.preventDefault();
                $('.dataList').empty();

                // serializeを使用し、formタグ内の入力情報を一括で取得、渡す
                let keywordValue = $("#keyword").serialize();

                $.ajax({
                        type: 'GET',
                        url: 'list/search',
                        dataType: 'json',
                        data: keywordValue // 検索フォームの入力値をControllerへ渡す
                        })
                    .done(function(data) {

                        // オブジェクトから絞り込みデータを一つずつ取り出す
                        $.each(data,
                            function(index, val) {

                                // 成功したとき
                                console.log('データ取得ができました');

                                // 検索結果をtbody内に追加する
                                $('.dataList').append
                                ('<tr><td>' + val.id + '</td>'+
                                '<td>' + '<img src="/public/'+ val.img_path +'" alt="商品画像" width="100">' + '</td>'+
                                '<td>' + val.product_name + '</td>'+
                                '<td>' + val.price + '</td>'+
                                '<td>' + val.stock + '</td>'+
                                '<td>' + val.comment + '</td>'+
                                '<td>' + val.company_name + '</td>'+
                                '<td>' +
                                    '<a href="/public/can/detail/'+ val.id + '" class="btn btn-info btn-sm mx-1">詳細表示</a>'+
                                    '<button data-user_id="'+ val.id + '" type="submit" class="btn btn-danger btn-sm mx-1">削除</button>'+
                                '</td></tr>');

                            });

                        // ソート実行（絞り込み検索後）
                        $(function(){
                            $("#fav-table").trigger("update");
                                sortTable();
                        });
                    })
                        // 失敗した時
                        .fail(function(){
                            console.log('データを取得できませんでした');
                        });
                    });
            });



        // 削除機能の実装
        $(function(){
            $(document).on('click','.btn-danger', function(){
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