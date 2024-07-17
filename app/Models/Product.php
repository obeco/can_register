<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
        'company_id'
    ];

    public function products() {
        // productsテーブルからデータを取得
        $products = DB::table('products')->get();
        return $products;
    }



    public function companies()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class,'id','product_id');
    }

}

