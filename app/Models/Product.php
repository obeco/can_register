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

    

    public function companies()
    {
        return $this->belongsTo(Company::class, 'id');
    }

}
    
