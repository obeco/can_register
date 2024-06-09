<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'company_name',
        'price',
        'stock',
        'comment',
        'img_path',
        'company_id'
    ];
 
    public function getProducts() {
        // productsテーブルからデータを取得
        $products = DB::table('products')->get();
        return $products;
    }

    // 情報登録用関数
    public function registArticle($data){
        // 登録処理
        DB::table('products')->insert([
            'product_name' => $data->product_name,
            'company_name' => $data->company_name,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $data->img_path,
            'company_id' => $data->company_name
        ]);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_name');
    }

}
    
