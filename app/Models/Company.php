<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name'
    ];

    public function getCompanies() {
        // companiesテーブルからデータを取得
        $companies = DB::table('companies')->get();
        return $companies;
    }
    

    // 情報登録用関数
    public function registArticle($data){
        // 登録処理
        DB::table('companies')->insert([
            'company_name' => $data->company_name
        ]);

    }

    // Companyモデルがproductsテーブルとリレーション関係を結ぶためのメソッド
    public function products()
    {
        return $this->hasMany(Product::class, 'company_name');
    }

}
