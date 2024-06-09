<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;

    public function getProducts() {
        // productsテーブルからデータを取得
        $products = DB::table('products')->get();

        return $products;
    }

    // 情報取得用関数
    public function getList() {
        // articlesテーブルからデータを取得
        $articles = DB::table('articles')->get();
        // ->get()でarticlesテーブルを全件取得する

        return $articles;
        // $articlesにはテーブルからの取得結果が詰まっている
        // それをreturnすることで、呼び出し元に返している
        // 呼び出しもとは、コントローラーの$articles = $model->getList()
        // 検索結果を返却しているので、上記のコントローラーの記述は最終的に
        // $articles = 「articlesテーブルから全件取得した結果」になる
    }

    // 情報登録用関数
    public function registArticle($data){

        // 登録処理
        DB::table('articles')->insert([
            'product_name' => $data->product_name,
            'company_name' => $data->company_name,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
        ]);
    
// registArticle($data)の$dataは、コントローラーから呼び出す時に渡された情報が入ってくる
// コントローラーの$model->registArticle($request)と言う記述箇所
// つまり、$dataにはビュー画面で入力された情報が入っている

// コントローラーでは$requestと書いているのに、モデルでは$dataと書いていることに疑問を持つ方もいるかもしれませんが、
// 実は双方で名前を統一する必要はありません。大事なのは名前ではなく順番である

// たとえば、コントローラー側で
// $model->registArticle($name, $price)、
// モデル側で
// public function registArticle($data01, $data02)
// と書いていたとしましょう。

// この場合、$nameは$data01と、$priceは$data02と対応します。

// このように記述した順番通りに、呼び出した関数に渡されるので、複数引数を記述する場合は 記載順を意識しましょう。

        
        // articlesテーブルへの新規登録処理
        // insertが新規登録のための命令文
        // 更新する場合はupdate
        // ‘カラム名’ => 登録する値 という形 になっている

        // 登録する値として、$data->titleと書かれていて
        // $dataにはビューで入力された値が入っている
        // その中からtitleという箇所を指定している、ビュー画面の name=‘title’という箇所を参照している
        // '大元のデータ' ->　大元のデータ内の特定の〇〇　を指定している
    }

}
