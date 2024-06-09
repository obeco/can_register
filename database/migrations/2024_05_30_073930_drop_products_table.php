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
        //
        Schema::dropIfExists('products');
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable();
            $table->integer('company_name');
            $table->string('product_name');
            $table->integer('price');
            $table->integer('stock');
            $table->text('img_path');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }
};
