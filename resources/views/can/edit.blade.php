
@extends('layouts.app')

@section('content')
<div class="form-group row">
    <form method="post" action="{{ route('update.product', ['id' => $product->id ]) }}" enctype="multipart/form-data">
    @csrf
        <div>
            <label for="ID">ID</label>
            <p>"{{ $product->id }}"</p>
        </div>

        <!-- メッセージ表示 -->
        @if(session('message'))
            <x-message :message="session('message')" />
        @endif

        <div>
            <label for="product_name">商品名</label>
            <input type="text" name="product_name" id="product_name" value="{{ $product->product_name }}">
            @if($errors->has('product_name'))
                <p>{{ $errors->first('product_name') }}</p>
            @endif
        </div>

        <div>
            <label for="company_name">メーカー名</label>
            <select name="company" data-toggle="select">
                <option value="">メーカー名</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('id', $product->company_id) == $company->id ? 'selected' : '' }}>
                        <!-- 三項演算子　 -->
                    {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('company'))
                <p>{{ $errors->first('company_name') }}</p>
            @endif
        </div>

        <div>
            <label for="price">価格</label>
            <input type="text" name="price" id="price" value="{{ $product->price }}">
            @if($errors->has('price'))
                <p>{{ $errors->first('price') }}</p>
            @endif
        </div>

        <div>
            <label for="stock">在庫数</label>
            <input type="text" name="stock" id="stock" value="{{ $product->stock }}">
            @if($errors->has('stock'))
                <p>{{ $errors->first('stock') }}</p>
            @endif
        </div>

        <div>
            <label for="comment">コメント</label>
            <input type="text" name="comment" id="comment" value="{{ $product->comment }}">
            @if($errors->has('comment'))
                <p>{{ $errors->first('comment') }}</p>
            @endif
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
            <p class="text-danger">画像がある場合は、もう一度選択してください。</p>
        </div>

        <button type="submit">更新する</button>
    </form>
    <a href="{{ route('show.list') }}">戻る</a>
</div>
@endsection
