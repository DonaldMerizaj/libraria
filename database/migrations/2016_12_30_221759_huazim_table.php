<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HuazimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huazim', function (Blueprint $table) {
            $table->increments('huazim_id');
            $table->integer('id_klient')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('id_libri')->unsigned();
            $table->integer('sasia');
            $table->dateTime('data_marrjes')->nullable();
            $table->dateTime('data_dorezimit')->nullable();
            $table->smallInteger('kthyer');//nese eshte kthyer ose jo (1/0)

        });

        Schema::table('huazim', function (Blueprint $table){
            $table->foreign('id_klient')->references('klient_id')->on('klient');
            $table->foreign('id_user')->references('user_id')->on('user');
            $table->foreign('id_libri')->references('libri_id')->on('libri');
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
