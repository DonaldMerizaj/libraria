<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KlientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klient', function (Blueprint $table) {
            $table->increments('klient_id');
            $table->string('emri');
            $table->string('mbiemri');
            $table->string('email');
            $table->string('cel');
            $table->integer('id_login')->unsigned();
//            $table->integer('status');//aktiv ose jo
            $table->timestamps();
        });

        Schema::table('klient', function (Blueprint $table){
           $table->foreign('id_login')->references('login_id')->on('login');
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
