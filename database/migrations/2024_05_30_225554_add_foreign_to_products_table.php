<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->bigInteger('company_id')->nullable()->unsigned();
            // unsignedを書かなかったらforeignを追加できないエラーになった。
            $table->foreign('company_id')->references('id')->on('companies');


            // 1行目はuser_idカラムを追加するコマンドで、2行目がforeign_keyを作成するコマンドです。
            // 2行目を説明すると、
            // 作ったcompany_idカラムをforeign_keyとして設定し、companiesテーブルのidを参照するんだよ
            // という事が書かれています。
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
