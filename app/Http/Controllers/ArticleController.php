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
            $file_name = $image->getClientOriginalName();
            // storage/app/public/imagesフォルダ内に、取得したファイル名で保存
            $image->storeAs('public/images', $file_name);
            // データベース登録用に、ファイルパスを作成
            $img_path = 'storage/images/'.$file_name;

        } else {
            $img_path = null;
        }

        // プルダウンリストからメーカー名を選択登録する
        $company_id = $request->input(['company']); // 選択したメーカー名のidを取得
        $products = Product::query(); // productsテーブルの情報を取得

        foreach($products as $query){
            $query->where('company_id',$company_id)->get();
        }

        $company_selected = Company::find($company_id); // companyテーブルから選択したリストのidに該当する情報を取得
        $company_name = $company_selected->company_name; // 上記からcompany_nameを取得
        
        // トランザクション開始
        DB::beginTransaction();
        try {
            Product::create([
                'product_name' => $request->product_name,
                'company_name' => $company_name,
                'price' => $request->price,
                'stock' => $request->stock,
                'comment' => $request->comment,
                'img_path' => $img_path,
                'company_id' => $company_id
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
            }
    return to_route('show.list', compact('products'));
    }

    
    // 更新登録
    public function updateProduct(ArticleRequest $request, $id){
        if($request){
            $company_id = $request->input(['company']);
        }
        $company = Company::find($company_id);
        $company_name = $company->company_name;

        // 画像ファイルの取得
        $image = $request->file('image');

        // TODO：詳細画面 → 編集画面へ遷移後、元々のimageが選択されている状態にしたい

        if($request->hasFile('image')){
            // 画像ファイルのファイル名を取得
            $file_name = $image->getClientOriginalName();
            // storage/app/public/imagesフォルダ内に、取得したファイル名で保存
            $image->storeAs('public/images', $file_name);
            // データベース登録用に、ファイルパスを作成
            $img_path = 'storage/images/'.$file_name;

        } else {
            $img_path = null;
        }

        // トランザクション開始
        DB::beginTransaction();
        try {
            $product = Product::find($id);   
            $product->company_id = $company_id;
            $product->product_name = $request->product_name;
            $product->company_name = $company_name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;
            $product->img_path = $img_path;
            $product->save();
 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            // TODO：エラーメッセージを表示させたい
            return back();
        }
        $products = Product::all();

        return to_route('show.list',compact('products'));
    }
    

    // 一覧表示関数
    public function showList(Request $request){

        // productテーブルから情報をとってくる
        $query = Product::query();

        // ユーザーが入れたキーワード（request）をkeywordに入れる
        $keyword = $request->keyword;
        // プルダウンで選択したメーカーidをcompanyに入れる
        $company = $request->input('company');
        

        if($keyword){
            $split1 = mb_convert_kana($keyword, 's');
            // keywordに含まれるスペース全角を半角に
            $split2 = preg_split('/[\s]+/', $split1);
            // 空白で区切り、配列になる
            foreach($split2 as $keyword){
                // 上記の配列をforeachで回す
            $query->where('product_name','LIKE','%'.$keyword. '%');

        }
        }
        if($company){
            $query->where('company_id',$company);
        }
        
        // ページネーション
        $products = $query->paginate(5);

        $companies = Company::all();

        return view ('can.list', compact('products','companies'));
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
    public function showEdit ($id){
        $product = Product::find($id);
        $companies = Company::all();
        return view('can.edit', compact('product','companies'));
    }

    // 行削除機能
    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {    
            $product = Product::find($id);
            $product->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }    
        return redirect()->route('show.list');
    }

}



?>