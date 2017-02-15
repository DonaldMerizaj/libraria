<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InventarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventar', function (Blueprint $table) {
            $table->increments('inventar_id');
            $table->integer('sasia_hyrje');
            $table->integer('id_libri')->unsigned();
            $table->integer('gjendje');
//            $table->integer('id_libri');
        });

        Schema::table('inventar', function (Blueprint $table){
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
