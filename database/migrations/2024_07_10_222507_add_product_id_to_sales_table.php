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
        Schema::table('sales', function (Blueprint $table) {
            // カラム追加
            $table->bigInteger('product_id')->after('id')->unsigned();
            // カラムの外部キー制約追加
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // 外部キー制約（外部接続）の削除
            $table->dropForeign('sales_product_id_foreign');
            // カラムの削除
            $table->dropColumn('product_id');
        });
    }
};
