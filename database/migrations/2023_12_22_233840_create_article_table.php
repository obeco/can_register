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
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name');
            $table->string('company_name');
            $table->bigIncrements('price');
            $table->bigIncrements('stock');
            $table->text('comment')->nullable();
            $table->timestamps();
            });        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');

        Schema::create('user_infomations', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('id');
            $table->string('user_name');
            $table->string('user_password');
            $table->timestamps();

            // ユーザ名
            // メールアドレス
            // パスワード
            // 時間
        });

        Schema::create('pd_infomations', function (Blueprint $table) {
            // $table->id();
            $table->bigIncrements('id');
            $table->string('maker_name');
            $table->string('pd_name');
            $table->string('pd_image');
            $table->integer('pd_price');
            $table->integer('pd_count');
            $table->text('comment');
            $table->timestamps();
            // ID
            // 商品名
            // メーカー名
            // 商品画像
            // 商品名
            // 価格
            // 在庫数
            // コメント
            // 時間
        });
    }
};
