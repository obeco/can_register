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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('street_address')->nullable();
            $table->string('representive_name')->nullable();
            $table->timestamps();

            // $table->foreign('company_id')->references('id')->on('companies');
            // $table->foreign(外部キーカラム)->references(主キーカラム)->on(主キーテーブル);
            // foreign は「外国の、外側の」
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
