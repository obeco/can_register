<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function purchase(Request $request)
{

    $product_id = $request->input('product_id'); // 選択された商品のIDを取得
    $quantity = $request->input('quantity'); // 購入数を取得

    // 選択された商品情報を取得
    $product = Product::find($product_id);

    // 商品が存在しない場合のメッセージ
    if(!$product){
        return response()->json(['message' => '該当の商品がありません'], 404);
    }
    // 在庫が不足している場合のメッセージ
    if($product->stock < $quantity){
        return response()->json(['message' => '商品の在庫が不足しています'], 400);
    }

    // トランザクション開始
    DB::beginTransaction();
    try {
        // 在庫を減少させる
        $product->stock -= $quantity;
        $product->save();

        // Salesテーブルに商品IDを保存
        $sale = new Sale([
            'product_id' => $product_id
        ]);
        $sale->save();

        DB::commit();
        return response()->json(['message' => '商品が購入されました！']);

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('message', '商品を購入できませんでした。');
    }
    
}
}
