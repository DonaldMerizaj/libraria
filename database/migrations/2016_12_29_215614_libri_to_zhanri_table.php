<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LibriToZhanriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_to_zh', function (Blueprint $table) {
            $table->increments('l_to_zh_id');
            $table->integer('id_libri')->unsigned();
            $table->integer('id_zhanri')->unsigned();
        });

        Schema::table('l_to_zh', function (Blueprint $table){
            $table->foreign('id_libri')->references('libri_id')->on('libri');
            $table->foreign('id_zhanri')->references('zhanri_id')->on('zhanri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
