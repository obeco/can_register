@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <p>商品新規登録画面</p>

        <!-- メッセージ表示 -->
        @if(session('message'))
            <x-message :message="session('message')" />
        @endif

        <form action="{{ route('store.product') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="product_name">商品名<span class="text-danger">*</span></label>
                <input id="product_name" type="vachar" name="product_name" placeholder="例:コーラ" value="{{ old('product_name') }}">
                @if($errors->has('product_name'))
                    <p>{{ $errors->first('product_name') }}</p>
                @endif
            </div>

            <div class="mb-3">
                <label for="company_name">メーカー名<span class="text-danger">*</span></label>
                <!-- プルダウン検索（メーカー名） -->
                <div>
                    <select name="company" data-toggle="select">
                        <option value="">メーカー名を選択</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="price">価格<span class="text-danger">*</span></label>
                <input id="price" type="int" name="price" placeholder="例:120" value="{{ old('price') }}">

            </div>

            <div class="mb-3">
                <label for="stock">在庫数<span class="text-danger">*</span></label>
                <input id="stock" type="int" name="stock" placeholder="例:120" value="{{ old('stock') }}">

            </div>

            
            <div class="mb-3">
                <label for="comment">コメント</label>
                <input id="comment" type="text" name="comment" placeholder="例:120" value="{{ old('comment') }}">

            </div>

            <div class="mb-3">
                <label for="image" class="form-label">商品画像</label>
                <input id="image" type="file" name="image" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary">新規登録</button>
        </form>

    <a href="{{ route('show.list') }}">戻る</a>         
    </div>
</div>
@endsection
