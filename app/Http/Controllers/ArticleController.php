<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller {


    // 新規商品登録
    public function storeProduct(ArticleRequest $request){

        // 画像ファイルの取得
        $image = $request->file('image');

        if($request->hasFile('image')){
            // 画像ファイルのファイル名を取得
            $original = $image->getClientOriginalName();
            // 日時をファイル名の前につける
            $file_name = date('Ymd_His').'_'.$original;
            // storage/app/public/imagesフォルダ内に、取得したファイル名で保存
            $image->storeAs('public/images', $file_name);
            // データベース登録用に、ファイルパスを作成
            $img_path = 'storage/images/'.$file_name;
        } else {
            $img_path = null;
        }

        // プルダウンリストからメーカー名を選択登録する
        $company_id = $request->input(['company']);

        $products = Product::query(); // productsテーブルの情報を取得

        foreach($products as $product){
            $product->where('company_id',$company_id)->get();
        }
        
        // トランザクション開始
        DB::beginTransaction();
        try {
            Product::create([
                'company_id' => $request->company,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'stock' => $request->stock,
                'comment' => $request->comment,
                'img_path' => $img_path
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e);
            return back()->with('message', '情報が正しく入力されませんでした');
            }
            return to_route('show.list', compact('products'))->with('message', '新規商品情報を登録しました。');
        }

    
    // 更新登録
    public function updateProduct(ArticleRequest $request){

        $id = $request->id;
        $product = Product::find($id);

        // 画像ファイルの取得
        $image = $request->file('image');

        if($request->hasFile('image')){
            // 画像ファイルのファイル名を取得
            $original = $image->getClientOriginalName();
            // storage/app/public/imagesフォルダ内に、取得したファイル名で保存
            $image->storeAs('public/images', $original);
            // データベース登録用に、ファイルパスを作成
            $img_path = 'storage/images/'.$original;
        } else {
            $img_path = null;
        }

        // 選択されたcompany_idを取得
        $company_id = $request->input(['company']);

        // トランザクション開始
        DB::beginTransaction();
        try {
            $product->company_id = $company_id;
            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;
            $product->img_path = $img_path;
            $product->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('message', '情報が正しく入力されませんでした');
        }

        $products = Product::all();

        return to_route('show.list',compact('products'))->with('message', '更新登録が完了しました。');
    }
    

    // 一覧表示関数
    public function showList(Request $request){

        // productテーブルの情報取得
        $product = Product::query();

        
        // 絞り込んだデータをproductsに入れる
        $products = $product->get();

        // メーカー名プルダウン用
        $companies = Company::all();

        return view ('can.list', compact('products','companies'));
    }

    // 検索機能
    public function searchList(Request $request){

        // productテーブルの情報取得
        $product = Product::query();

        // 検索フォーム（非同期）
        // keyword＝ユーザーが入力したキーワード
        $keyword = $request->keyword;
        if($keyword){
            $split1 = mb_convert_kana($keyword, 's');
            // keywordに含まれるスペース全角を半角に
            $split2 = preg_split('/[\s]+/', $split1);
            // 空白で区切り、配列になる
            foreach($split2 as $keyword){
            // 上記の配列をforeachで回す
            $product->where('product_name','LIKE','%'.$keyword. '%')->get();
        }
        }

        // 商品名の検索キーワードがある場合、そのキーワードを含む商品を表示
        if($keyword = $request->keyword){
            $product->where('product_name', 'LIKE', "%{$keyword}%");
        }
        

        // 最小価格が指定されている場合、その価格以上の商品を表示
        if($min_price = $request->min_price){
            $product->where('price', '>=', $min_price);
        }

        // 最大価格が指定されている場合、その価格以下の商品を表示
        if($max_price = $request->max_price){
            $product->where('price', '<=', $max_price);
        }

        // 最小在庫数が指定されている場合、その在庫数以上の商品を表示
        if($min_stock = $request->min_stock){
            $product->where('stock', '>=', $min_stock);
        }

        // 最大在庫数が指定されている場合、その在庫数以下の商品を表示
        if($max_stock = $request->max_stock){
            $product->where('stock', '<=', $max_stock);
        }

        // メーカー名プルダウンの実装
        if($company_id = $request->input('company')){
            $product->where('company_id',$company_id)->get();
        }

        // ソートのパラメータが指定されている場合、そのカラムでソートを行う
        if($sort = $request->sort){
            // directionがdescでない場合は、デフォルトでascとする
            $direction = $request->direction == 'desc' ? 'desc' : 'asc';
            // 第一引数で基準、第二引数で昇順か降順
            $product->orderBy($sort, $direction);
        }
               // 絞り込んだデータをproductsに入れる
               $products = $product->get();

               // 取得したデータをjsonで返す
               return response()->json($products);
    }


    // 登録画面表示
    public function showRegist(){
        $companies = Company::all();
        return view('can.regist',compact('companies'));
    }


    // 詳細画面表示
    public function showDetail($id){
        $product = Product::find($id);
        return view('can.detail', compact('product'));
    }


    // 編集画面表示
    public function showEdit($id){
        $product = Product::find($id);
        $companies = Company::all();
        return view('can.edit', compact('product','companies'));
    }

    // Ajax行削除機能
    public function destroyProduct ($id) {

        DB::beginTransaction();
        try {    
            \Log::info($id);
            $product = Product::findOrFail($id);
            $product->delete();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }    
    }

}

?>